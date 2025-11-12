<?php
$accepted = Yii::$app->request->cookies->getValue('cookie_consent', '');

?>

<?php if (!$accepted): ?>
    <div id="cookie-consent" class="">
        <div class="content">
            <div class="text">
                <div class="text-content">
                    Oldalainkon HTTP-sütiket (cookies) használunk a felhasználói élmény növelése érdekében.
                    <a href="/adatkezelesi-tajekoztato" target="_blank">Adatkezelési tájékoztató</a>
                </div>
            </div>
            <div class="button">
                <button class="btn" data-accept-cookies>Rendben</button>
            </div>
        </div>
    </div>
<?php endif; ?>

