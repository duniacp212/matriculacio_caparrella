/**
 * Validador de DNI/NIE per Espanya
 * 
 * Ús:
 * import { validateDNI, validateNIE, validateDNINIE } from './dni-validator.js';
 * 
 * o bé carregar directament:
 * <script src="assets/js/dni-validator.js"></script>
 */

class DNIValidator {
    
    /**
     * Lletres vàlides per DNI segons l'algoritme oficial
     */
    static LETRAS_DNI = 'TRWAGMYFPDXBNJZSQVHLCKE';
    
    /**
     * Lletres inicials vàlides per NIE
     */
    static LETRAS_NIE = ['X', 'Y', 'Z'];
    
    /**
     * Valida un DNI espanyol (format: 12345678A)
     * 
     * @param {string} dni - DNI a validar
     * @returns {Object} - { valid: boolean, error: string|null }
     */
    static validateDNI(dni) {
        // Eliminar espais i convertir a majúscules
        dni = dni.toString().trim().toUpperCase();
        
        // Verificar format bàsic (8 dígits + 1 lletra)
        const dniRegex = /^[0-9]{8}[A-Z]$/;
        
        if (!dniRegex.test(dni)) {
            return {
                valid: false,
                error: 'Format de DNI invàlid. Ha de ser 8 números seguits d\'una lletra (ex: 12345678A)'
            };
        }
        
        // Extreure número i lletra
        const numero = parseInt(dni.substring(0, 8));
        const letra = dni.charAt(8);
        
        // Calcular lletra correcta
        const letraCorrecta = this.LETRAS_DNI.charAt(numero % 23);
        
        if (letra !== letraCorrecta) {
            return {
                valid: false,
                error: `El DNI es incorrecte.`
            };
        }
        
        return {
            valid: true,
            error: null
        };
    }
    
    /**
     * Valida un NIE espanyol (format: X1234567A)
     * 
     * @param {string} nie - NIE a validar
     * @returns {Object} - { valid: boolean, error: string|null }
     */
    static validateNIE(nie) {
        // Eliminar espais i convertir a majúscules
        nie = nie.toString().trim().toUpperCase();
        
        // Verificar format bàsic (X/Y/Z + 7 dígits + 1 lletra)
        const nieRegex = /^[XYZ][0-9]{7}[A-Z]$/;
        
        if (!nieRegex.test(nie)) {
            return {
                valid: false,
                error: 'Format de NIE invàlid. Ha de començar amb X, Y o Z seguit de 7 números i una lletra'
            };
        }
        
        // Substituir la lletra inicial pel número corresponent
        let nieNumerico = nie
            .replace('X', '0')
            .replace('Y', '1')
            .replace('Z', '2');
        
        // Extreure número i lletra
        const numero = parseInt(nieNumerico.substring(0, 8));
        const letra = nie.charAt(8);
        
        // Calcular lletra correcta
        const letraCorrecta = this.LETRAS_DNI.charAt(numero % 23);
        
        if (letra !== letraCorrecta) {
            return {
                valid: false,
                error: `El NIE es incorrecte.`
            };
        }
        
        return {
            valid: true,
            error: null
        };
    }
    
    /**
     * Valida DNI o NIE automàticament
     * 
     * @param {string} documento - DNI o NIE a validar
     * @returns {Object} - { valid: boolean, error: string|null, type: 'DNI'|'NIE'|null }
     */
    static validateDNINIE(documento) {
        documento = documento.toString().trim().toUpperCase();
        
        if (!documento) {
            return {
                valid: false,
                error: 'El DNI/NIE no pot estar buit',
                type: null
            };
        }
        
        // Detectar si és NIE (comença amb X, Y o Z)
        const esNIE = this.LETRAS_NIE.includes(documento.charAt(0));
        
        if (esNIE) {
            const resultado = this.validateNIE(documento);
            return {
                ...resultado,
                type: 'NIE'
            };
        } else {
            const resultado = this.validateDNI(documento);
            return {
                ...resultado,
                type: 'DNI'
            };
        }
    }
    
    /**
     * Formata un DNI/NIE afegint un guió (opcional)
     * 
     * @param {string} documento - DNI o NIE
     * @returns {string} - DNI/NIE formatat (ex: 12345678-A)
     */
    static format(documento) {
        documento = documento.toString().trim().toUpperCase().replace(/[^0-9XYZ]/g, '');
        
        if (documento.length === 9) {
            return documento.substring(0, 8) + '-' + documento.charAt(8);
        }
        
        return documento;
    }
    
    /**
     * Afegeix validació en temps real a un input
     * 
     * @param {HTMLInputElement} input - Element input
     * @param {Function} callback - Funció a cridar quan canvia la validesa
     */
    static bindToInput(input, callback = null) {
        input.addEventListener('input', function() {
            const value = this.value.trim().toUpperCase();
            
            // Només validar si té 9 caràcters
            if (value.length === 9) {
                const resultado = DNIValidator.validateDNINIE(value);
                
                // Afegir/treure classes Bootstrap
                if (resultado.valid) {
                    this.classList.remove('is-invalid');
                    this.classList.add('is-valid');
                } else {
                    this.classList.remove('is-valid');
                    this.classList.add('is-invalid');
                }
                
                // Mostrar error si hi ha un element .invalid-feedback
                const feedback = this.parentElement.querySelector('.invalid-feedback');
                if (feedback) {
                    feedback.textContent = resultado.error || '';
                }
                
                // Cridar callback si existeix
                if (callback) {
                    callback(resultado);
                }
            } else {
                this.classList.remove('is-valid', 'is-invalid');
            }
        });
        
        // Auto-convertir a majúscules
        input.addEventListener('blur', function() {
            this.value = this.value.trim().toUpperCase();
        });
    }
}

// Exportar per ús amb modules ES6
if (typeof module !== 'undefined' && module.exports) {
    module.exports = DNIValidator;
}

// Fer disponible globalment
if (typeof window !== 'undefined') {
    window.DNIValidator = DNIValidator;
}
