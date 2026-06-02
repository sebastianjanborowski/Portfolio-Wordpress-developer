<?php get_header(); ?>

<div class="beauty-page-hero">
    <div class="container">
        <div class="beauty-page-hero__inner">
            <img class="holistic-header-ornament" src="<?php echo get_template_directory_uri(); ?>/assets/img/produkcja/podkreslnik_title_cut.png" alt="Podkreślnik tytułu podstrony">
            <h1 class="beauty-page-title"><?php the_title(); ?></h1>
        </div>
    </div>
</div>

<?php
$faq_face = [
    [
        'question' => 'Jak dobrać krem do rodzaju cery?',
        'answer' => 'Kluczem jest obserwacja reakcji skóry po umyciu. Jeśli jest ściągnięta, potrzebuje lipidów; jeśli błyszczy się w strefie T – regulacji.',
        'recommendation' => 'Zapraszam na profesjonalną diagnostykę skóry, która jest fundamentem każdej terapii.'
    ],
    [
        'question' => 'Czy krem z filtrem SPF jest konieczny zimą?',
        'answer' => 'Tak, promieniowanie UVA przenika przez chmury i szyby, przyspieszając fotostarzenie i powstawanie przebarwień przez cały rok.',
        'recommendation' => 'Warto wzmocnić skórę zabiegiem z witaminą C, która działa synergicznie z filtrami ochronnymi.'
    ],
    [
        'question' => 'Jak pozbyć się rozszerzonych porów?',
        'answer' => 'Porów nie da się całkowicie zamknąć, ale można je oczyścić i zwęzić, dbając o elastyczność ujść gruczołów łojowych.',
        'recommendation' => 'Doskonale sprawdzi się peeling kawitacyjny lub oczyszczanie wodorowe, które odświeżą cerę bez podrażnień.'
    ],
    [
        'question' => 'Kiedy zacząć stosować kosmetyki przeciwstarzeniowe?',
        'answer' => 'Prewencja jest ważniejsza niż leczenie. Już po 25. roku życia produkcja kolagenu naturalnie spada.',
        'recommendation' => 'Idealnym startem będzie mezoterapia mikroigłowa, która pobudzi skórę do naturalnej regeneracji.'
    ],
    [
        'question' => 'Dlaczego moja skóra jest szara i zmęczona?',
        'answer' => 'Często to wynik stresu, braku snu lub niedotlenienia tkanek. Skóra potrzebuje bodźca do odnowy.',
        'recommendation' => 'Polecam rytuał dotleniający, który przywróci twarzy zdrowy blask i energię.'
    ],
    [
        'question' => 'Jak dbać o cerę naczynkową?',
        'answer' => 'Unikaj gwałtownych zmian temperatur i agresywnych peelingów mechanicznych. Stawiaj na składniki wzmacniające ściany naczyń.',
        'recommendation' => 'Kojący zabieg z rutyną i witaminą C pomoże wyciszyć rumień i wzmocnić naczynka.'
    ],
    [
        'question' => 'Czy trądzik u dorosłych leczy się inaczej niż u nastolatków?',
        'answer' => 'Tak, trądzik dorosłych często ma podłoże hormonalne lub stresogenne i wymaga delikatniejszego podejścia, by nie przesuszyć skóry.',
        'recommendation' => 'Skutecznym rozwiązaniem są peelingi chemiczne dobrane indywidualnie do stanu zapalnego.'
    ],
    [
        'question' => 'Czym różni się serum od kremu?',
        'answer' => 'Serum to koncentrat składników aktywnych o mniejszej cząsteczce, który dociera głębiej. Krem stanowi barierę ochronną na powierzchni.',
        'recommendation' => 'Aby składniki serum wchłonęły się jeszcze lepiej, polecam infuzję tlenową.'
    ],
    [
        'question' => 'Jak pozbyć się cieni pod oczami?',
        'answer' => 'Cienie mogą wynikać z cienkiej skóry lub zastojów limfatycznych. Ważne jest nawilżenie i stymulacja mikrokrążenia.',
        'recommendation' => 'Specjalistyczny zabieg na okolicę oczu z drenażem pomoże rozjaśnić spojrzenie.'
    ],
    [
        'question' => 'Czy można łączyć retinol z kwasami?',
        'answer' => 'To silne składniki. Ich łączenie w jednej rutynie bez konsultacji może uszkodzić barierę hydrolipidową.',
        'recommendation' => 'Bezpieczniejszą alternatywą jest profesjonalna kuracja kwasowa przeprowadzona w gabinecie pod okiem eksperta.'
    ],
];

$faq_body = [
    [
        'question' => 'Jak skutecznie walczyć z cellulitem?',
        'answer' => 'Kluczowa jest systematyczność: połączenie diety, ruchu i profesjonalnej stymulacji tkanek.',
        'recommendation' => 'Bardzo polecam masaż podciśnieniowy, który mechanicznie stymuluje tkanki.'
    ],
    [
        'question' => 'Dlaczego masaż twarzy jest tak ważny?',
        'answer' => 'Rozluźnia napięcia mięśniowe, które odpowiadają za powstawanie zmarszczek mimicznych i poprawia owal twarzy.',
        'recommendation' => 'Zapraszam na masaż Kobido, zwany niechirurgicznym liftingiem.'
    ],
    [
        'question' => 'Jak przygotować skórę do depilacji?',
        'answer' => 'Na kilka dni przed warto wykonać delikatny peeling, aby zapobiec wrastaniu włosków i usunąć martwy naskórek.',
        'recommendation' => 'Jeśli szukasz długofalowych efektów, warto rozważyć depilację laserową.'
    ],
    [
        'question' => 'Moja skóra na ciele jest bardzo sucha, co robić?',
        'answer' => 'Samo nawilżanie to za mało, potrzebne jest złuszczenie, by składniki odżywcze mogły wniknąć głębiej.',
        'recommendation' => 'Odżywczy peeling całego ciała połączony z maską przywróci skórze miękkość.'
    ],
    [
        'question' => 'Czy masaż pomaga w walce ze stresem?',
        'answer' => 'Oczywiście. Obniża poziom napięcia i wprowadza organizm w stan głębokiej regeneracji.',
        'recommendation' => 'Relaksacyjny masaż aromaterapeutyczny to dobry sposób na odzyskanie spokoju.'
    ],
    [
        'question' => 'Jak poprawić jędrność skóry po odchudzaniu?',
        'answer' => 'Skóra potrzebuje zagęszczenia i pobudzenia produkcji nowych włókien kolagenowych.',
        'recommendation' => 'Świetne efekty przynosi fala radiowa RF, która napina skórę.'
    ],
    [
        'question' => 'Czym jest holistyczne podejście w kosmetyce?',
        'answer' => 'To traktowanie organizmu jako całości. Wygląd skóry jest odzwierciedleniem zdrowia, emocji i stylu życia.',
        'recommendation' => 'Zachęcam do konsultacji holistycznej.'
    ],
    [
        'question' => 'Czy masaż pleców wpływa na wygląd twarzy?',
        'answer' => 'Tak. Napięcia w karku i plecach mogą powodować zastoje limfatyczne i opuchliznę na twarzy.',
        'recommendation' => 'Połączenie masażu pleców z masażem twarzy daje bardzo dobre efekty odprężenia.'
    ],
    [
        'question' => 'Jak często powinnam odwiedzać gabinet kosmetyczny?',
        'answer' => 'Optymalnie raz w miesiącu, zgodnie z cyklem odnowy komórkowej naskórka.',
        'recommendation' => 'Dobrym nawykiem jest regularny zabieg pielęgnacyjny dobrany do pory roku.'
    ],
    [
        'question' => 'Czy zabiegi kosmetyczne są bezpieczne w ciąży?',
        'answer' => 'Tak, ale muszą być dobrane bardzo starannie. Unikamy prądów, ultradźwięków i niektórych kwasów.',
        'recommendation' => 'Bezpieczny będzie delikatny masaż twarzy lub zabieg nawilżający.'
    ],
];
?>


<section class="holistic-faq-section py-5">
    <div class="container">
        <div class="row g-4">

            <div class="col-12 col-lg-6">
                <div class="holistic-faq-card">
                    <h3 class="holistic-faq-title">
                        Twarz i pielęgnacja domowa
                    </h3>

                    <?php foreach ($faq_face as $index => $item) : ?>
                        <div class="holistic-faq-item">
                            <details <?php echo $index === 0 ? 'open' : ''; ?>>
                                <summary>
                                    <?php echo esc_html($item['question']); ?>
                                </summary>

                                <div class="holistic-faq-content">
                                    <p>
                                        <strong>Odpowiedź:</strong>
                                        <?php echo esc_html($item['answer']); ?>
                                    </p>

                                    <p>
                                        <strong>Zalecenie:</strong>
                                        <?php echo esc_html($item['recommendation']); ?>
                                    </p>
                                </div>
                            </details>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="col-12 col-lg-6">
                <div class="holistic-faq-card">
                    <h3 class="holistic-faq-title">
                        Ciało i relaks
                    </h3>

                    <?php foreach ($faq_body as $index => $item) : ?>
                        <div class="holistic-faq-item">
                            <details <?php echo $index === 0 ? 'open' : ''; ?>>
                                <summary>
                                    <?php echo esc_html($item['question']); ?>
                                </summary>

                                <div class="holistic-faq-content">
                                    <p>
                                        <strong>Odpowiedź:</strong>
                                        <?php echo esc_html($item['answer']); ?>
                                    </p>

                                    <p>
                                        <strong>Zalecenie:</strong>
                                        <?php echo esc_html($item['recommendation']); ?>
                                    </p>
                                </div>
                            </details>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

        </div>
    </div>
</section>

<?php get_footer(); ?>