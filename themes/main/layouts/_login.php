<div class="modal-window " data-login-modal="">
    <div class="modal-bg" data-close-modal=""></div>
    <div class="modal-window-content">
        <div class="modal-box">
            <div class="modal-box-header">
                <div class="modal-title"><?=\app\models\Vasarlo::current() ? 'Bejelentkezve mint' : 'Bejelentkezés'?></div>
                <div class="modal-close" data-close-modal="">
                    <img src="/img/dragcards/cart/close-x-dark.svg" alt="Dragcards">
                </div>
            </div>
            <div class="modal-box-content">
                <?php if (\app\models\Vasarlo::current()): ?>

                <form data-ajax-form="" data-action="/api/logout">
                    <div style="font-size: 130%; text-align: center;">
                        <?=\app\models\Vasarlo::current()->nev?>
                    </div>
                    <div style=" text-align: center;">
                        <?=\app\models\Vasarlo::current()->email?>
                    </div>
                    <div style=" margin-bottom: 25px; text-align: center;">
                        <?=\app\models\Vasarlo::current()->telefonszam?>
                    </div>

                    <div class="modal-button-row">
                        <button type="submit">Kijelentkezés</button>
                    </div>
                </form>

                <?php else: ?>

                    <form data-ajax-form="" data-action="/api/login">
                        <div class="input-row fancy-placeholder has-text">
                            <label>E-mail cím</label>
                            <div class="input-box">
                                <input type="text" name="email" placeholder="E-mail cím">
                            </div>
                            <div class="error-message">Kötelező kitölteni!</div>
                        </div>
                        <div class="input-row fancy-placeholder">
                            <label>
                                Jelszó
                            </label>
                            <div class="input-box">
                                <input type="password" name="password" placeholder="Jelszó">
                            </div>
                            <div class="error-message">Kötelező kitölteni!</div>
                        </div>
                        <div class="forgot-pass-row">
                            <a href="javascript:void(0)" data-show-forgot-password-modal="" data-close-modal="">Elfelejtetted?</a>
                        </div>
                        <div class="modal-button-row">
                            <button type="submit">Bejelentkezés</button>
                        </div>
                    </form>
                    <div class="modal-footer">
                        Még nincs fiókod? <span class="fake-link" data-close-modal="" data-show-signup-modal="">Regisztrálj!</span>
                    </div>

                <?php endif; ?>
            </div>
        </div>
    </div>
</div>