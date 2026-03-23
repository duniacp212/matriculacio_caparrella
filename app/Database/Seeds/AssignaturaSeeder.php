<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AssignaturaSeeder extends Seeder
{
    private function netejar(string $text): string
    {
        $text = trim($text);
        $text = preg_replace('/^\d+\.\s*/', '', $text);
        $text = rtrim($text, '.');
        $text = preg_replace('/\s+/', ' ', $text);
        return mb_convert_case($text, MB_CASE_TITLE, "UTF-8");
    }

    private function getIdEstudi(string $tipus, int $nivell): ?int
    {
        return $this->db->table('estudi')
            ->where('tipus', $tipus)
            ->where('nivell', $nivell)
            ->get()
            ->getRow('id_estudi');
    }

    private function afegir(array &$data, array &$dataOpt, string $tipus, int $nivell, array $assignatures, array $optatives = []): void
    {
        $id = $this->getIdEstudi($tipus, $nivell);

        if (!$id)
            return;

        foreach (array_unique($assignatures) as $nom) {
            $data[] = [
                'id_estudi' => $id,
                'nom' => $this->netejar($nom),
                'estat' => 1
            ];
        }

        foreach (array_unique($optatives) as $nom) {
            $dataOpt[] = [
                'id_estudi' => $id,
                'nom' => $this->netejar($nom),
                'estat' => 1
            ];
        }
    }

    public function run()
    {
        $this->db->query('SET FOREIGN_KEY_CHECKS=0');
        $this->db->table('assignatura')->truncate();
        $this->db->table('optativa')->truncate();
        $this->db->query('SET FOREIGN_KEY_CHECKS=1');

        $data = [];
        $dataOpt = [];

        $eso = [
            'Llengua catalana',
            'Llengua castellana',
            'Anglès',
            'Matemàtiques',
            'Ciències socials',
            'Biologia',
            'Física i Química',
            'Tecnologia',
            'Educació física',
            'Música',
            'Plàstica'
        ];

        foreach ([1, 2, 3] as $nivell) {
            $this->afegir($data, $dataOpt, 'ESO', $nivell, $eso);
        }

        $this->afegir($data, $dataOpt, 'ESO', 4, $eso, [
            'Economia',
            'Llatí',
            'Informàtica',
            'Tecnologia aplicada'
        ]);

        $bat_comuns = ['Història', 'Filosofia', 'Llengua catalana', 'Llengua castellana'];

        $this->afegir(
            $data,
            $dataOpt,
            'Batxillerat Ciències i tecnologia',
            1,
            array_merge($bat_comuns, ['Matemàtiques', 'Física', 'Química', 'Biologia', 'Dibuix tècnic'])
        );

        $this->afegir(
            $data,
            $dataOpt,
            'Batxillerat Ciències i tecnologia',
            2,
            array_merge($bat_comuns, ['Matemàtiques', 'Física', 'Química', 'Biologia', 'Dibuix tècnic'])
        );

        $this->afegir(
            $data,
            $dataOpt,
            'Batxillerat Humanitats i ciències socials',
            1,
            array_merge($bat_comuns, ['Llatí', 'Grec', 'Economia', 'Literatura'])
        );

        $this->afegir(
            $data,
            $dataOpt,
            'Batxillerat Humanitats i ciències socials',
            2,
            array_merge($bat_comuns, ['Història de l’art', 'Literatura', 'Geografia', 'Economia'])
        );

        $fp_basica_1 = [
            "Mòdul professional 1: Ciències aplicades I",
            "Mòdul professional 3: Comunicació i societat I",
            "Mòdul professional 5: Entorn laboral (UF1+UF3)",
            "Mòdul professional 6: Muntatge i manteniment de sistemes i components informàtics",
            "Mòdul professional 8: Ofimàtica i arxiu de documents"
        ];


        $fp_basica_2 = [

            "Mòdul professional 2: Ciències aplicades II",
            "Mòdul professional 4: Comunicació i societat II",
            "Mòdul professional 5: Entorn laboral (UF2)",
            "Mòdul professional 7: Operacions auxiliars per a la configuració i l'explotació",
            "Mòdul professional 9: Instal·lació i manteniment de xarxes per a transmissió de dades",
            "Mòdul professional 10: Síntesi",
            "Mòdul professional 11: Formació en centres de treball"
        ];


        $this->afegir($data, $dataOpt, 'FP Bàsica Informàtica d’Oficina', 1, $fp_basica_1);
        $this->afegir($data, $dataOpt, 'FP Bàsica Informàtica d’Oficina', 2, $fp_basica_2);

        $asix_1 = [
            "0369. Implantació de sistemes operatius",
            "0370. Planificació i administració de xarxes",
            "0371. Fonaments de maquinari",
            "0372. Gestió de bases de dades",
            "0373. Llenguatge de marques i sistemes de gestió d’informació"
        ];

        $asix_2 = [
            "0374. Administració de sistemes operatius",
            "0375. Serveis de xarxa i internet",
            "0376. Implantació d’aplicacions web",
            "0377. Administració de sistemes gestors de bases de dades",
            "0378. Seguretat i alta disponibilitat",
            "0379. Projecte intermodular d'administració de sistemes informàtics en xarxa",
            "0179. Anglès professional",
            "1665. Digitalització aplicada als sectors productius",
            "1708. Sostenibilitat aplicada al sistema productiu",
            "1709. Itinerari personal per a l'ocupabilitat I",
            "1710. Itinerari personal per a l'ocupabilitat II"
        ];

        $this->afegir($data, $dataOpt, 'CFGS Administració de sistemes informàtics en xarxa', 1, $asix_1);
        $this->afegir($data, $dataOpt, 'CFGS Administració de sistemes informàtics en xarxa', 2, $asix_2);

        $dam_1 = [
            "0483. Sistemes informàtics",
            "0484. Bases de dades",
            "0485. Programació",
            "0373. Llenguatges de marques i sistemes de gestió d’informació",
            "0487. Entorns de desenvolupament",
            "1709. Itinerari personal per a l'ocupabilitat I",
            "1665. Digitalització aplicada als sectors productius",
            "1708. Sostenibilitat aplicada al sistema productiu",
            "0179. Anglès professional"
        ];

        $dam_2 = [
            "0486. Accés a dades",
            "0488. Desenvolupament d’interfícies",
            "0489. Programació multimèdia i dispositius mòbils",
            "0490. Programació de serveis i processos",
            "0491. Sistemes de gestió empresarial",
            "0492. Projecte intermodular d'administració de sistemes informàtics en xarxa",
            "1710. Itinerari personal per a l'ocupabilitat II"
        ];

        $this->afegir($data, $dataOpt, 'CFGS Desenvolupament d’Aplicacions Multiplataforma', 1, $dam_1);
        $this->afegir($data, $dataOpt, 'CFGS Desenvolupament d’Aplicacions Multiplataforma', 2, $dam_2);

        $daw_1 = [
            "0483. Sistemes informàtics",
            "0484. Bases de dades",
            "0485. Programació",
            "0373. Llenguatges de marques i sistemes de gestió d’informació",
            "0487. Entorns de desenvolupament",
            "1709. Itinerari personal per a l'ocupabilitat I",
            "1665. Digitalització aplicada als sectors productius",
            "1708. Sostenibilitat aplicada al sistema productiu",
            "0179. Anglès professional"
        ];

        $daw_2 = [
            "0612. Desenvolupament web en entorn client",
            "0613. Desenvolupament web en entorn servidor",
            "0614. Desplegament d’aplicacions web",
            "0615. Disseny d’interfícies web",
            "0492. Projecte intermodular d'administració de sistemes informàtics en xarxa",
            "1710. Itinerari personal per a l'ocupabilitat II"
        ];

        $this->afegir($data, $dataOpt, 'CFGS Desenvolupament d’Aplicacions Web (dual)', 1, $daw_1);
        $this->afegir($data, $dataOpt, 'CFGS Desenvolupament d’Aplicacions Web (dual)', 2, $daw_2);

        $automocio_1 = [
            "0291. Sistemes elèctrics, de seguretat i confortabilitat",
            "0292. Sistemes de transmissió de forces i trens de rodatge",
            "0293. Motors tèrmics i els seus sistemes auxiliars",
            "0179. Anglès professional",
            "1665. Digitalització aplicada als sectors productius"
        ];

        $automocio_2 = [
            "0294. Elements amovibles i fixos no estructurals",
            "0295. Tractament i recobriment de superfícies",
            "0296. Estructures dels vehicles",
            "0297. Gestió i logística del manteniment de vehicles",
            "0309. Tècniques de comunicació i de relacions",
            "0298 Projecte intermodular d’Automoció"

        ];

        $this->afegir($data, $dataOpt, 'CFGS Automoció', 1, $automocio_1);
        $this->afegir($data, $dataOpt, 'CFGS Automoció', 2, $automocio_2);

        $disseny_1 = [
            "0179. Anglès Professional",
            "1665. Digitalització aplicada als sectors productius",
            "1709. Itinerari personal per a l'ocupabilitat I",
            "1708. Sostenibilitat aplicada al sistema productiu",
            "1484. Disseny i planificació de projectes editorials multimèdia",
            "1478. Organització dels processos de preimpressió digital"

        ];

        $disseny_2 = [
            "1486. Projecte intermodular de Disseny i edició de publicacions impreses i multimèdia",
            "1710. Itinerari personal per a l'ocupabilitat II",
            "1485. Desenvolupament i publicació de productes editorials multimèdia",
            "1482. Producció editorial",
            "1481. Gestió de la producció en processos d’edició",
            "1480. Comercialització de productes gràfics i atenció al client",
            "1479. Disseny de productes gràfics",
            "1417. Materials de producció gràfica"

        ];

        $this->afegir($data, $dataOpt, 'CFGS Disseny i edició de publicacions impreses i multimèdia', 1, $disseny_1);
        $this->afegir($data, $dataOpt, 'CFGS Disseny i edició de publicacions impreses i multimèdia', 2, $disseny_2);


        $illuminacio_1 = [
            "1158. Planificació de càmera en audiovisuals",
            "1159. Presa d’imatge audiovisual",
            "1160. Planificació de la il·luminació",
            "1161. Luminotècnia",
            "1162. Control de la il·luminació",
            "1163. Projectes fotogràfics",
            "1164. Presa fotogràfica",
            "1165. Tractament fotogràfic digital",
            "1166. Processos finals fotogràfics",
            "0179. Anglès professional",
            "1665. Digitalització aplicada als sectors productius",
            "1708. Sostenibilitat aplicada al sistema productiu",
            "1709. Itinerari personal per a l’ocupabilitat I"
        ];
        $illuminacio_2 = [
            "1167. Enregistrament i edició de reportatges audiovisuals",
            "1160. Projectes d’il·luminació",
            "1168. Projecte intermodular d’il·luminació, captació i tractament d’imatge",
            "1710. Itinerari personal per a l’ocupabilitat II"
        ];

        $this->afegir($data, $dataOpt, 'CFGS Il·luminació, captació i tractament d’imatge', 1, $illuminacio_1);
        $this->afegir($data, $dataOpt, 'CFGS Il·luminació, captació i tractament d’imatge', 2, $illuminacio_2);



        $manteniment_1 = [
            "1051. Circuits electrònics analògics",
            "1052. Equips microprogramables",
            "1053. Manteniment d’equips de radiocomunicacions",
            "1054. Manteniment d’equips de veu i dades",
            "1056. Manteniment d'equips d’àudio",
            "1057. Manteniment d'equips de vídeo",
            "0179. Anglès professional",
            "1665. Digitalització aplicada als sectors productius",
            "1708. Sostenibilitat aplicada al sistema productiu",
            "1709. Itinerari personal per a l’ocupabilitat I"
        ];
        $manteniment_2 = [
            "1055. Manteniment d’equips d’electrònica industrial",
            "1058. Tècniques i processos de muntatge i manteniment d'equips electrònics",
            "1059. Infraestructures i desenvolupament del manteniment electrònic",
            "1060. Projecte intermodular de manteniment electrònic",
            "1710. Itinerari personal per a l’ocupabilitat II"
        ];

        $this->afegir($data, $dataOpt, 'CFGS Manteniment electrònic', 1, $manteniment_1);
        $this->afegir($data, $dataOpt, 'CFGS Manteniment electrònic', 2, $manteniment_2);

        $asix_ciber_1 = [
            "0369. Implantació de sistemes operatius",
            "0370. Planificació i administració de xarxes",
            "0371. Fonaments de maquinari",
            "0372. Gestió de bases de dades",
            "0373. Llenguatges de marques i sistemes de gestió d’informació",
            "0179. Anglès professional",
            "1665. Digitalització aplicada als sectors productius",
            "1708. Sostenibilitat aplicada al sistema productiu",
            "1709. Itinerari personal per a l’ocupabilitat I"
        ];
        $asix_ciber_2 = [
            "0374. Administració de sistemes operatius",
            "0375. Serveis de xarxa i internet",
            "0376. Implantació d’aplicacions web",
            "0377. Administració de sistemes gestors de bases de dades",
            "0378. Seguretat i alta disponibilitat",
            "0379. Projecte intermodular d’administració de sistemes informàtics en xarxa",
            "1710. Itinerari personal per a l’ocupabilitat II"
        ];

        $this->afegir($data, $dataOpt, 'CFGS Administració de sistemes informàtics en xarxa – perfil ciberseguretat', 1, $asix_ciber_1);
        $this->afegir($data, $dataOpt, 'CFGS Administració de sistemes informàtics en xarxa – perfil ciberseguretat', 2, $asix_ciber_2);

        $carrosseria_1 = [
            "0294. Elements amovibles",
            "0295. Elements metàl·lics i sintètics",
            "0296. Preparació de superfícies",
            "0297. Elements fixos",
            "0179. Anglès professional",
            "1665. Digitalització aplicada als sectors productius",
            "1708. Sostenibilitat aplicada al sistema productiu",
            "1709. Itinerari personal per a l’ocupabilitat I"
        ];
        $carrosseria_2 = [
            "0298. Embelliment de superfícies",
            "0299. Estructures del vehicle",
            "0300. Personalització de carrosseries",
            "0301. Projecte intermodular de carrosseria",
            "1710. Itinerari personal per a l’ocupabilitat II"
        ];
        $this->afegir($data, $dataOpt, 'CFGM Carrosseria', 1, $carrosseria_1);
        $this->afegir($data, $dataOpt, 'CFGM Carrosseria', 2, $carrosseria_2);

        $electromecanica_camions_1 = [
            "0452. Motors",
            "0453. Sistemes auxiliars del motor",
            "0454. Circuits de fluids. Suspensió i direcció",
            "0455. Sistemes de càrrega i arrencada",
            "1709. Itinerari personal per a l’ocupabilitat I"
        ];

        $electromecanica_camions_2 = [
            "0456. Circuits elèctrics auxiliars del vehicle",
            "0457. Sistemes de transmissió i frenada",
            "0458. Mecanitzat bàsic",
            "1665. Digitalització aplicada als sectors productius",
            "1708. Sostenibilitat aplicada al sistema productiu"
        ];

        $electromecanica_camions_3 = [
            "0459. Projecte intermodular d’electromecànica de vehicles",
            "0179. Anglès professional",
            "1710. Itinerari personal per a l’ocupabilitat II"
        ];

        $this->afegir(
            $data,
            $dataOpt,
            'CFGM Electromecànica de vehicles adaptat a vehicles industrials (camions)',
            1,
            $electromecanica_camions_1
        );

        $this->afegir(
            $data,
            $dataOpt,
            'CFGM Electromecànica de vehicles adaptat a vehicles industrials (camions)',
            2,
            $electromecanica_camions_2
        );

        $this->afegir(
            $data,
            $dataOpt,
            'CFGM Electromecànica de vehicles adaptat a vehicles industrials (camions)',
            3,
            $electromecanica_camions_3
        );


        $electromecanica_automobils_1 = [
            "0452. Motors",
            "0453. Sistemes auxiliars del motor",
            "0454. Circuits de fluids. Suspensió i direcció",
            "0455. Sistemes de càrrega i arrencada",
            "0179. Anglès professional",
            "1665. Digitalització aplicada als sectors productius",
            "1709. Itinerari personal per a l’ocupabilitat I"
        ];

        $electromecanica_automobils_2 = [
            "0456. Circuits elèctrics auxiliars del vehicle",
            "0457. Sistemes de transmissió i frenada",
            "0458. Mecanitzat bàsic",
            "0459. Projecte intermodular d’electromecànica de vehicles",
            "1708. Sostenibilitat aplicada al sistema productiu",
            "1710. Itinerari personal per a l’ocupabilitat II"
        ];

        $this->afegir($data, $dataOpt, 'CFGM Electromecànica de vehicles automòbils', 1, $electromecanica_automobils_1);
        $this->afegir($data, $dataOpt, 'CFGM Electromecànica de vehicles automòbils', 2, $electromecanica_automobils_2);

        $telecomunicacions_1 = [
            "0237. Infraestructures comunes de telecomunicació en habitatges i edificis",
            "0238. Instal·lacions domòtiques",
            "0239. Electrònica aplicada",
            "0240. Equips microinformàtics",
            "1665. Digitalització aplicada als sectors productius",
            "1709. Itinerari personal per a l’ocupabilitat I"
        ];

        $telecomunicacions_2 = [
            "0241. Infraestructures de xarxes de dades i sistemes de telefonia",
            "0242. Instal·lacions elèctriques bàsiques",
            "0243. Instal·lacions de megafonia i sonorització",
            "0244. Circuit tancat de televisió i seguretat electrònica",
            "0245. Instal·lacions de radiocomunicacions",
            "0246. Projecte intermodular d’instal·lacions de telecomunicacions",
            "0179. Anglès professional",
            "1708. Sostenibilitat aplicada al sistema productiu",
            "1710. Itinerari personal per a l’ocupabilitat II"
        ];

        $this->afegir($data, $dataOpt, 'CFGM Instal·lacions de Telecomunicacions', 1, $telecomunicacions_1);
        $this->afegir($data, $dataOpt, 'CFGM Instal·lacions de Telecomunicacions', 2, $telecomunicacions_2);

        $preimpressio_1 = [
            "0877. Tractament de textos",
            "0878. Tractament d’imatges en mapa de bits",
            "0879. Imposició i obtenció digital de la forma impressora",
            "0880. Preparació de materials per a impressió",
            "1665. Digitalització aplicada als sectors productius",
            "1709. Itinerari personal per a l’ocupabilitat I"
        ];

        $preimpressio_2 = [
            "0881. Tractament d’imatges vectorials",
            "0882. Compaginació",
            "0883. Identificació de materials en preimpressió",
            "0884. Projecte intermodular de preimpressió digital",
            "0179. Anglès professional",
            "1708. Sostenibilitat aplicada al sistema productiu",
            "1710. Itinerari personal per a l’ocupabilitat II"
        ];

        $this->afegir($data, $dataOpt, 'CFGM Preimpressió digital', 1, $preimpressio_1);
        $this->afegir($data, $dataOpt, 'CFGM Preimpressió digital', 2, $preimpressio_2);

        $smx_1 = [
            "0221. Muntatge i manteniment d’equips",
            "0222. Sistemes operatius monopunt",
            "0223. Aplicacions ofimàtiques",
            "0225. Xarxes locals",
            "1665. Digitalització aplicada als sectors productius",
            "1709. Itinerari personal per a l’ocupabilitat I"
        ];

        $smx_2 = [
            "0224. Sistemes operatius en xarxa",
            "0226. Seguretat informàtica",
            "0227. Serveis en xarxa",
            "0228. Aplicacions web",
            "0229. Projecte intermodular de sistemes microinformàtics i xarxes",
            "0179. Anglès professional",
            "1708. Sostenibilitat aplicada al sistema productiu",
            "1710. Itinerari personal per a l’ocupabilitat II"
        ];

        $this->afegir($data, $dataOpt, 'CFGM Sistemes Microinformàtics i Xarxes', 1, $smx_1);
        $this->afegir($data, $dataOpt, 'CFGM Sistemes Microinformàtics i Xarxes', 2, $smx_2);

        $video_dj_so_1 = [
            "1298. Instal·lació i muntatge d’equips de so",
            "1299. Captació i enregistrament de so",
            "1300. Preparació de sessions de vídeo discjòquei",
            "1301. Animació musical en viu",
            "1665. Digitalització aplicada als sectors productius",
            "1709. Itinerari personal per a l’ocupabilitat I"
        ];

        $video_dj_so_2 = [
            "1302. Mescla directa, edició i postproducció de so",
            "1303. Control, edició i postproducció de vídeo",
            "1304. Animació visual en viu",
            "1305. Projecte intermodular de vídeo discjòquei i so",
            "0179. Anglès professional",
            "1708. Sostenibilitat aplicada al sistema productiu",
            "1710. Itinerari personal per a l’ocupabilitat II"
        ];

        $this->afegir($data, $dataOpt, 'CFGM Vídeo, discjòquei i so', 1, $video_dj_so_1);
        $this->afegir($data, $dataOpt, 'CFGM Vídeo, discjòquei i so', 2, $video_dj_so_2);


        $conduccio_transport_1 = [
            "1325. Conducció racional i segura",
            "1326. Entorn normatiu, econòmic i social del transport",
            "1327. Operacions de transport",
            "1328. Planificació del transport i logística",
            "1665. Digitalització aplicada als sectors productius",
            "1709. Itinerari personal per a l’ocupabilitat I"
        ];

        $conduccio_transport_2 = [
            "1329. Serveis de transport de viatgers",
            "1330. Serveis de transport de mercaderies",
            "1331. Organització del transport de viatgers",
            "1332. Organització del transport de mercaderies",
            "1333. Projecte intermodular de conducció de vehicles de transport per carretera",
            "0179. Anglès professional",
            "1708. Sostenibilitat aplicada al sistema productiu",
            "1710. Itinerari personal per a l’ocupabilitat II"
        ];

        $this->afegir($data, $dataOpt, 'CFGM Conducció de vehicles de transport per carretera', 1, $conduccio_transport_1);
        $this->afegir($data, $dataOpt, 'CFGM Conducció de vehicles de transport per carretera', 2, $conduccio_transport_2);


        $pfi_electrotecnic = [
            "Operacions auxiliars de muntatge d’instal·lacions electrotècniques",
            "Operacions auxiliars de manteniment d’instal·lacions electrotècniques",
            "Instal·lacions elèctriques bàsiques",
            "Prevenció de riscos laborals",
            "Formació en centres de treball",
            "Estratègies i eines de comunicació",
            "Entorn social i territorial",
            "Estratègies i eines matemàtiques"
        ];

        $this->afegir($data, $dataOpt, 'PFI Auxiliar de muntatges d’instal·lacions electrotècniques en edifici', 1, $pfi_electrotecnic);


        $pfi_aigua_gas = [
            "Operacions auxiliars de muntatge d’instal·lacions elèctriques",
            "Operacions auxiliars de muntatge d’instal·lacions d’aigua",
            "Operacions auxiliars de muntatge d’instal·lacions de gas",
            "Prevenció de riscos laborals",
            "Formació en centres de treball",
            "Estratègies i eines de comunicació",
            "Entorn social i territorial",
            "Estratègies i eines matemàtiques"
        ];

        $this->afegir($data, $dataOpt, 'PFI Auxiliar de muntatges d’instal·lacions elèctriques, d\'aigua i gas', 1, $pfi_aigua_gas);


        $this->db->table('assignatura')->insertBatch($data);
        $this->db->table('optativa')->insertBatch($dataOpt);
    }
}