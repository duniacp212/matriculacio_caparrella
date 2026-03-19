/**
 * Validador de Formularis
 * 
 * Sistema complet de validació client-side per formularis
 * Compatible amb Bootstrap 5
 * 
 * Ús:
 * <script src="assets/js/form-validator.js"></script>
 * FormValidator.init('#myForm');
 */

class FormValidator {
    
    /**
     * Inicialitza el validador per un formulari
     * 
     * @param {string|HTMLFormElement} formSelector - Selector o element del formulari
     * @param {Object} options - Opcions de configuració
     */
    static init(formSelector, options = {}) {
        const form = typeof formSelector === 'string' 
            ? document.querySelector(formSelector) 
            : formSelector;
            
        if (!form) {
            console.error('Formulari no trobat:', formSelector);
            return;
        }
        
        const config = {
            realTimeValidation: true,
            showErrorMessages: true,
            scrollToError: true,
            ...options
        };
        
        // Afegir validació en temps real
        if (config.realTimeValidation) {
            this.addRealTimeValidation(form);
        }
        
        // Validar al submit
        form.addEventListener('submit', (e) => {
            if (!this.validateForm(form)) {
                e.preventDefault();
                
                if (config.scrollToError) {
                    this.scrollToFirstError(form);
                }
                
                return false;
            }
        });
    }
    
    /**
     * Valida tot el formulari
     * 
     * @param {HTMLFormElement} form - Element formulari
     * @returns {boolean} - True si és vàlid
     */
    static validateForm(form) {
        let isValid = true;
        
        // Validar tots els inputs requerits
        const inputs = form.querySelectorAll('input[required], textarea[required], select[required]');
        
        inputs.forEach(input => {
            if (!this.validateField(input)) {
                isValid = false;
            }
        });
        
        return isValid;
    }
    
    /**
     * Valida un camp individual
     * 
     * @param {HTMLInputElement} field - Camp a validar
     * @returns {boolean} - True si és vàlid
     */
    static validateField(field) {
        let isValid = true;
        let errorMessage = '';
        
        // Netejar validació anterior
        field.classList.remove('is-valid', 'is-invalid');
        
        // Saltar si està disabled o readonly
        if (field.disabled || field.readOnly) {
            return true;
        }
        
        const value = field.value.trim();
        const type = field.type;
        const required = field.hasAttribute('required');
        
        // 1. Validar required
        if (required && !value) {
            isValid = false;
            errorMessage = this.getErrorMessage(field, 'required');
        }
        
        // Si està buit i no és required, està OK
        if (!value && !required) {
            return true;
        }
        
        // 2. Validar tipus específics
        if (value && isValid) {
            switch (type) {
                case 'email':
                    isValid = this.validateEmail(value);
                    if (!isValid) errorMessage = this.getErrorMessage(field, 'email');
                    break;
                    
                case 'tel':
                    isValid = this.validatePhone(value);
                    if (!isValid) errorMessage = this.getErrorMessage(field, 'tel');
                    break;
                    
                case 'url':
                    isValid = this.validateURL(value);
                    if (!isValid) errorMessage = this.getErrorMessage(field, 'url');
                    break;
                    
                case 'number':
                    isValid = this.validateNumber(value, field);
                    if (!isValid) errorMessage = this.getErrorMessage(field, 'number');
                    break;
                    
                case 'date':
                    isValid = this.validateDate(value, field);
                    if (!isValid) errorMessage = this.getErrorMessage(field, 'date');
                    break;
            }
        }
        
        // 3. Validar patró personalitzat
        if (value && isValid && field.hasAttribute('pattern')) {
            const pattern = new RegExp(field.getAttribute('pattern'));
            isValid = pattern.test(value);
            if (!isValid) errorMessage = this.getErrorMessage(field, 'pattern');
        }
        
        // 4. Validar longitud mínima
        if (value && isValid && field.hasAttribute('minlength')) {
            const minLength = parseInt(field.getAttribute('minlength'));
            isValid = value.length >= minLength;
            if (!isValid) errorMessage = `Mínim ${minLength} caràcters`;
        }
        
        // 5. Validar longitud màxima
        if (value && isValid && field.hasAttribute('maxlength')) {
            const maxLength = parseInt(field.getAttribute('maxlength'));
            isValid = value.length <= maxLength;
            if (!isValid) errorMessage = `Màxim ${maxLength} caràcters`;
        }
        
        // 6. Validació personalitzada per data-validate
        if (value && isValid && field.hasAttribute('data-validate')) {
            const validationType = field.getAttribute('data-validate');
            
            switch (validationType) {
                case 'dni':
                    if (window.DNIValidator) {
                        const resultado = DNIValidator.validateDNINIE(value);
                        isValid = resultado.valid;
                        if (!isValid) errorMessage = resultado.error;
                    }
                    break;
                    
                case 'postal-code':
                    isValid = /^[0-9]{5}$/.test(value);
                    if (!isValid) errorMessage = 'El codi postal ha de tenir 5 dígits';
                    break;
                    
                case 'nif':
                    isValid = /^[0-9]{8}[A-Z]$/.test(value.toUpperCase());
                    if (!isValid) errorMessage = 'Format de NIF invàlid';
                    break;
            }
        }
        
        // Aplicar classes Bootstrap
        if (isValid) {
            field.classList.add('is-valid');
        } else {
            field.classList.add('is-invalid');
        }
        
        // Mostrar missatge d'error
        this.showErrorMessage(field, errorMessage);
        
        return isValid;
    }
    
    /**
     * Valida email
     */
    static validateEmail(email) {
        const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return regex.test(email);
    }
    
    /**
     * Valida telèfon (format espanyol)
     */
    static validatePhone(phone) {
        // Acceptar: 666777888, +34666777888, 666 77 78 88
        const cleanPhone = phone.replace(/\s/g, '');
        const regex = /^(\+34|0034)?[6-9][0-9]{8}$/;
        return regex.test(cleanPhone);
    }
    
    /**
     * Valida URL
     */
    static validateURL(url) {
        try {
            new URL(url);
            return true;
        } catch {
            return false;
        }
    }
    
    /**
     * Valida número
     */
    static validateNumber(value, field) {
        const num = parseFloat(value);
        
        if (isNaN(num)) return false;
        
        // Validar min
        if (field.hasAttribute('min')) {
            const min = parseFloat(field.getAttribute('min'));
            if (num < min) return false;
        }
        
        // Validar max
        if (field.hasAttribute('max')) {
            const max = parseFloat(field.getAttribute('max'));
            if (num > max) return false;
        }
        
        return true;
    }
    
    /**
     * Valida data
     */
    static validateDate(value, field) {
        const date = new Date(value);
        
        if (isNaN(date.getTime())) return false;
        
        // Validar min
        if (field.hasAttribute('min')) {
            const min = new Date(field.getAttribute('min'));
            if (date < min) return false;
        }
        
        // Validar max
        if (field.hasAttribute('max')) {
            const max = new Date(field.getAttribute('max'));
            if (date > max) return false;
        }
        
        return true;
    }
    
    /**
     * Afegeix validació en temps real
     */
    static addRealTimeValidation(form) {
        const inputs = form.querySelectorAll('input, textarea, select');
        
        inputs.forEach(input => {
            // Validar al perdre el focus
            input.addEventListener('blur', () => {
                if (input.value) {
                    this.validateField(input);
                }
            });
            
            // Validar mentre escriu (després que sigui invàlid)
            input.addEventListener('input', () => {
                if (input.classList.contains('is-invalid')) {
                    this.validateField(input);
                }
            });
        });
    }
    
    /**
     * Mostra missatge d'error
     */
    static showErrorMessage(field, message) {
        // Buscar o crear element de feedback
        let feedback = field.parentElement.querySelector('.invalid-feedback');
        
        if (!feedback) {
            feedback = document.createElement('div');
            feedback.className = 'invalid-feedback';
            field.parentElement.appendChild(feedback);
        }
        
        feedback.textContent = message;
    }
    
    /**
     * Obté missatge d'error per tipus
     */
    static getErrorMessage(field, type) {
        // Prioritzar missatge personalitzat
        const customMessage = field.getAttribute('data-error-' + type);
        if (customMessage) return customMessage;
        
        // Missatges per defecte
        const messages = {
            required: 'Aquest camp és obligatori',
            email: 'Introdueix un correu electrònic vàlid',
            tel: 'Introdueix un telèfon vàlid',
            url: 'Introdueix una URL vàlida',
            number: 'Introdueix un número vàlid',
            date: 'Introdueix una data vàlida',
            pattern: 'El format no és vàlid'
        };
        
        return messages[type] || 'Aquest camp no és vàlid';
    }
    
    /**
     * Desplaça fins al primer error
     */
    static scrollToFirstError(form) {
        const firstInvalid = form.querySelector('.is-invalid');
        
        if (firstInvalid) {
            firstInvalid.scrollIntoView({
                behavior: 'smooth',
                block: 'center'
            });
            firstInvalid.focus();
        }
    }
    
    /**
     * Neteja tota la validació del formulari
     */
    static clearValidation(form) {
        const fields = form.querySelectorAll('.is-valid, .is-invalid');
        
        fields.forEach(field => {
            field.classList.remove('is-valid', 'is-invalid');
        });
        
        const feedbacks = form.querySelectorAll('.invalid-feedback');
        feedbacks.forEach(feedback => {
            feedback.textContent = '';
        });
    }
    
    /**
     * Afegeix regla de validació personalitzada
     */
    static addCustomRule(name, validator, errorMessage) {
        this.customRules = this.customRules || {};
        this.customRules[name] = { validator, errorMessage };
    }
}

// Fer disponible globalment
if (typeof window !== 'undefined') {
    window.FormValidator = FormValidator;
}

// Exportar per ús amb modules
if (typeof module !== 'undefined' && module.exports) {
    module.exports = FormValidator;
}
