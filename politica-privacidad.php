<?php require_once 'includes/config.php'; ?>
<?php
$lang = $_GET['lang'] ?? '';
$allowed = ['es','en','fr','de','pt','it'];
if (!in_array($lang, $allowed, true)) { $lang = 'es'; }
$t = [
  'es' => [
    'title' => 'Política de Privacidad · Proyectos MCE',
    'subtitle' => 'Tratamiento de datos para desarrollo de software a medida (Colombia)',
    'sections' => [
      ['Responsable del Tratamiento', 'Proyectos MCE (Marlon Carabalí) es responsable del tratamiento de los datos personales recopilados en este sitio. Correo: <a class="text-blue-600 underline" href="mailto:contacto@proyectosmce.com">contacto@proyectosmce.com</a>.'],
      ['Datos que Recopilamos', 'Nombre, email, teléfono, empresa/proyecto, mensajes enviados, metadatos técnicos (IP, navegador) y, si aplica, archivos o enlaces compartidos en formularios.'],
      ['Finalidad y Base Legal', 'Responder consultas, enviar propuestas, gestionar proyectos y mejorar servicios. Base legal: tu consentimiento y, cuando proceda, ejecución de contrato o medidas precontractuales.'],
      ['Conservación', 'Mientras dure la relación comercial o sea necesario para las finalidades descritas, y el tiempo adicional requerido por obligaciones legales o defensa de reclamaciones.'],
      ['Derechos (ARCO)', 'Acceso, rectificación, cancelación, oposición, revocación del consentimiento y portabilidad cuando aplique. Solicítalos escribiendo a <a class="text-blue-600 underline" href="mailto:contacto@proyectosmce.com">contacto@proyectosmce.com</a>.'],
      ['Seguridad', 'Aplicamos medidas técnicas y organizativas razonables (acceso restringido, cifrado en tránsito, copias de seguridad). Ningún sistema es 100% seguro.'],
      ['Menores de Edad', 'Servicios dirigidos a empresas/adultos. No recopilamos intencionalmente datos de menores; si se recibe información, la eliminaremos tras notificación.'],
      ['Transferencias y Encargados', 'Podemos compartir datos con proveedores encargados (hosting, email, analítica) bajo contratos de confidencialidad. No vendemos datos personales.'],
      ['Modificaciones', 'Esta política puede actualizarse; la versión vigente es la publicada con su fecha.'],
    ],
    'back_home' => 'Volver al inicio',
    'contact' => 'Contactar'
  ],
  'en' => [
    'title' => 'Privacy Policy · MCE Projects',
    'subtitle' => 'Data processing for custom software development (Colombia)',
    'sections' => [
      ['Data Controller', 'MCE Projects (Marlon Carabalí) is responsible for personal data collected on this site. Email: <a class="text-blue-600 underline" href="mailto:contacto@proyectosmce.com">contacto@proyectosmce.com</a>.'],
      ['Data We Collect', 'Name, email, phone, company/project, messages sent, technical metadata (IP, browser) and any files/links you share in forms.'],
      ['Purpose and Legal Basis', 'To answer inquiries, send proposals, manage projects, and improve services. Legal basis: your consent and, where applicable, contract performance or pre-contractual steps.'],
      ['Retention', 'We keep data while the business relationship exists or as needed for stated purposes, plus any time required by law or for defense of claims.'],
      ['Your Rights', 'Access, rectification, erasure, objection, withdrawal of consent, and portability where applicable. Request via <a class="text-blue-600 underline" href="mailto:contacto@proyectosmce.com">contacto@proyectosmce.com</a>.'],
      ['Security', 'We apply reasonable technical/organizational measures (restricted access, in-transit encryption, backups). No system is 100% secure.'],
      ['Minors', 'Services are for businesses/adults. We do not knowingly collect data from minors; if received, we will delete it upon notice.'],
      ['Transfers/Processors', 'We may share data with service providers (hosting, email, analytics) under confidentiality agreements. We do not sell personal data.'],
      ['Changes', 'This policy may be updated; the current version is the one published with its date.'],
    ],
    'back_home' => 'Back to home',
    'contact' => 'Contact'
  ],
  'fr' => [
    'title' => 'Politique de confidentialité · Projets MCE',
    'subtitle' => 'Traitement des données pour le développement logiciel sur mesure (Colombie)',
    'sections' => [
      ['Responsable du traitement', 'Projets MCE (Marlon Carabalí) est responsable des données collectées. Email : <a class="text-blue-600 underline" href="mailto:contacto@proyectosmce.com">contacto@proyectosmce.com</a>.'],
      ['Données collectées', 'Nom, email, téléphone, entreprise/projet, messages, métadonnées techniques (IP, navigateur) et fichiers/liens fournis.'],
      ['Finalité et base légale', 'Répondre aux demandes, envoyer des propositions, gérer des projets, améliorer les services. Base légale : consentement et, le cas échéant, exécution d’un contrat ou mesures précontractuelles.'],
      ['Conservation', 'Pendant la relation commerciale ou selon les besoins des finalités, plus le temps requis par la loi ou la défense de réclamations.'],
      ['Droits', 'Accès, rectification, suppression, opposition, retrait du consentement et portabilité si applicable. Adresse : <a class="text-blue-600 underline" href="mailto:contacto@proyectosmce.com">contacto@proyectosmce.com</a>.'],
      ['Sécurité', 'Mesures techniques et organisationnelles raisonnables (accès restreint, chiffrement en transit, sauvegardes). Aucun système n’est 100 % sûr.'],
      ['Mineurs', 'Services destinés à entreprises/adultes. Nous ne collectons pas volontairement les données de mineurs; si reçu, nous les supprimons.'],
      ['Transferts et sous-traitants', 'Nous pouvons partager des données avec des prestataires (hébergement, email, analytique) sous clauses de confidentialité. Aucune vente de données.'],
      ['Modifications', 'Cette politique peut être mise à jour; la version en vigueur est celle publiée avec sa date.'],
    ],
    'back_home' => 'Retour à l’accueil',
    'contact' => 'Contact'
  ],
  'de' => [
    'title' => 'Datenschutzerklärung · MCE Projekte',
    'subtitle' => 'Datenverarbeitung für individuelle Softwareentwicklung (Kolumbien)',
    'sections' => [
      ['Verantwortlicher', 'MCE Projekte (Marlon Carabalí) ist für die erhobenen Daten verantwortlich. E-Mail: <a class="text-blue-600 underline" href="mailto:contacto@proyectosmce.com">contacto@proyectosmce.com</a>.'],
      ['Welche Daten wir erfassen', 'Name, E-Mail, Telefon, Firma/Projekt, gesendete Nachrichten, technische Metadaten (IP, Browser) und ggf. Dateien/Links aus Formularen.'],
      ['Zweck und Rechtsgrundlage', 'Antwort auf Anfragen, Angebote senden, Projekte managen, Services verbessern. Rechtsgrundlage: Einwilligung und ggf. Vertrag/vertragsvorbereitende Maßnahmen.'],
      ['Speicherdauer', 'Solange die Geschäftsbeziehung besteht oder für die Zwecke nötig, plus gesetzliche Aufbewahrung bzw. Verteidigung von Ansprüchen.'],
      ['Betroffenenrechte', 'Auskunft, Berichtigung, Löschung, Widerspruch, Widerruf der Einwilligung und Datenübertragbarkeit, sofern anwendbar. Anfrage an <a class="text-blue-600 underline" href="mailto:contacto@proyectosmce.com">contacto@proyectosmce.com</a>.'],
      ['Sicherheit', 'Angemessene technische/organisatorische Maßnahmen (eingeschränkter Zugriff, Verschlüsselung in Transit, Backups). Kein System ist 100% sicher.'],
      ['Minderjährige', 'Services für Unternehmen/Erwachsene. Keine absichtliche Erhebung von Daten Minderjähriger; bei Eingang löschen wir sie.'],
      ['Übermittlungen/Auftragsverarbeiter', 'Weitergabe an Dienstleister (Hosting, E-Mail, Analytics) unter Vertraulichkeit. Keine Datenverkäufe.'],
      ['Änderungen', 'Diese Policy kann aktualisiert werden; maßgeblich ist die veröffentlichte Version mit Datum.'],
    ],
    'back_home' => 'Zur Startseite',
    'contact' => 'Kontakt'
  ],
  'pt' => [
    'title' => 'Política de Privacidade · Projetos MCE',
    'subtitle' => 'Tratamento de dados para desenvolvimento sob medida (Colômbia)',
    'sections' => [
      ['Responsável pelo tratamento', 'Projetos MCE (Marlon Carabalí) é responsável pelos dados coletados. Email: <a class="text-blue-600 underline" href="mailto:contacto@proyectosmce.com">contacto@proyectosmce.com</a>.'],
      ['Dados coletados', 'Nome, email, telefone, empresa/projeto, mensagens, metadados técnicos (IP, navegador) e arquivos/links enviados nos formulários.'],
      ['Finalidade e base legal', 'Responder consultas, enviar propostas, gerir projetos e melhorar serviços. Base legal: consentimento e, quando aplicável, execução de contrato ou medidas pré-contratuais.'],
      ['Conservação', 'Enquanto durar a relação comercial ou conforme necessário para as finalidades, mais o tempo exigido por lei ou defesa de reclamações.'],
      ['Direitos', 'Acesso, retificação, cancelamento, oposição, revogação do consentimento e portabilidade, quando aplicável. Solicite via <a class="text-blue-600 underline" href="mailto:contacto@proyectosmce.com">contacto@proyectosmce.com</a>.'],
      ['Segurança', 'Medidas técnicas/organizacionais razoáveis (acesso restrito, criptografia em trânsito, backups). Nenhum sistema é 100% seguro.'],
      ['Menores', 'Serviços para empresas/adultos. Não coletamos intencionalmente dados de menores; se ocorrer, excluiremos.'],
      ['Transferências e encarregados', 'Podemos compartilhar dados com fornecedores (hosting, email, analytics) sob confidencialidade. Não vendemos dados.'],
      ['Modificações', 'Esta política pode ser atualizada; vale a versão publicada com a data.'],
    ],
    'back_home' => 'Voltar ao início',
    'contact' => 'Contato'
  ],
  'it' => [
    'title' => 'Informativa sulla privacy · Progetti MCE',
    'subtitle' => 'Trattamento dati per sviluppo software su misura (Colombia)',
    'sections' => [
      ['Titolare del trattamento', 'Progetti MCE (Marlon Carabalí) è responsabile dei dati raccolti. Email: <a class="text-blue-600 underline" href="mailto:contacto@proyectosmce.com">contacto@proyectosmce.com</a>.'],
      ['Dati raccolti', 'Nome, email, telefono, azienda/progetto, messaggi, metadati tecnici (IP, browser) e file/link inviati nei moduli.'],
      ['Finalità e base giuridica', 'Rispondere alle richieste, inviare proposte, gestire progetti e migliorare i servizi. Base giuridica: consenso e, se applicabile, esecuzione del contratto o misure precontrattuali.'],
      ['Conservazione', 'Per la durata del rapporto commerciale o quanto necessario alle finalità, più il tempo richiesto dalla legge o per difesa da reclami.'],
      ['Diritti', 'Accesso, rettifica, cancellazione, opposizione, revoca del consenso e portabilità quando applicabile. Richiedi a <a class="text-blue-600 underline" href="mailto:contacto@proyectosmce.com">contacto@proyectosmce.com</a>.'],
      ['Sicurezza', 'Misure tecniche/organizzative ragionevoli (accesso ristretto, cifratura in transito, backup). Nessun sistema è 100% sicuro.'],
      ['Minori', 'Servizi per aziende/adulti. Non raccogliamo volontariamente dati di minori; se ricevuti, li elimineremo.'],
      ['Trasferimenti e responsabili', 'Possiamo condividere dati con fornitori (hosting, email, analytics) con obbligo di riservatezza. Non vendiamo dati personali.'],
      ['Modifiche', "Questa informativa può essere aggiornata; fa fede la versione pubblicata con la data."],
    ],
    'back_home' => 'Torna alla home',
    'contact' => 'Contatto'
  ],
];
$tx = $t[$lang] ?? $t['es'];
?>
<?php require_once 'includes/header.php'; ?>
<script>
  window.mceCurrentLang = '<?php echo $lang; ?>';
  localStorage.setItem('siteLang','<?php echo $lang; ?>');
</script>

<style>
/* Ocultar navegación principal y menú móvil en páginas legales */
.hidden.md\:flex { display: none !important; }
.md\:hidden.flex.items-center.gap-3 { display: none !important; }
#mobile-menu { display: none !important; }
</style>

<main class="bg-slate-100">
  <section class="max-w-5xl mx-auto px-4 py-12">
    <article class="bg-white rounded-2xl shadow-lg border border-slate-200 px-6 md:px-10 py-10 space-y-8">
      <header class="space-y-2">
        <p class="text-sm text-slate-500">Actualizado: <?php echo date('F d, Y'); ?></p>
        <h1 class="text-3xl font-bold" style="color:#1a2c3e;"><?php echo $tx['title']; ?></h1>
        <p class="text-lg font-semibold" style="color:#2c5282;"><?php echo $tx['subtitle']; ?></p>
      </header>

      <?php foreach ($tx['sections'] as $index => $sec): ?>
        <section class="space-y-3">
          <h2 class="text-xl font-semibold" style="color:#1a2c3e;"><?php echo ($index+1).'. '.$sec[0]; ?></h2>
          <p class="text-base leading-relaxed" style="color:#4a5568;"><?php echo $sec[1]; ?></p>
        </section>
      <?php endforeach; ?>

      <footer class="pt-2 flex flex-wrap gap-3">
        <a href="<?php echo app_url(); ?>" class="inline-flex items-center px-4 py-2 rounded-lg border border-slate-200 text-slate-800 font-semibold hover:bg-slate-50 transition"><?php echo $tx['back_home']; ?></a>
        <a href="<?php echo app_url('contacto.php'); ?>" class="inline-flex items-center px-4 py-2 rounded-lg bg-blue-600 text-white font-semibold hover:bg-blue-700 transition"><?php echo $tx['contact']; ?></a>
      </footer>
    </article>
  </section>
</main>

<!-- Página de privacidad sin footer para foco en el contenido -->
</body>
</html>
