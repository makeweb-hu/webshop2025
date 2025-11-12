<div class="modal-window " data-signup-modal="">
    <div class="modal-bg" data-close-modal=""></div>
    <div class="modal-window-content">
        <div class="modal-box">
            <div class="modal-box-header">
                <div class="modal-title">Regisztráció</div>
                <div class="modal-close" data-close-modal="">
                    <img src="/img/dragcards/cart/close-x-dark.svg" alt="Dragcards">
                </div>
            </div>
            <div class="modal-box-content">
                <form data-ajax-form="" data-action="/api/signup" data-reset-on-success="">
                    <div class="input-row fancy-placeholder">
                        <label>Név</label>
                        <div class="input-box">
                            <input type="text" name="name" placeholder="Név">
                        </div>
                        <div class="error-message">Adja meg a nevét!</div>
                    </div>
                    <div class="input-row fancy-placeholder ">
                        <label>E-mail cím</label>
                        <div class="input-box">
                            <input type="text" name="email" placeholder="E-mail cím">
                        </div>
                        <div class="error-message">Adja meg e-mail címét!</div>
                    </div>
                    <div class="input-row fancy-placeholder">
                        <label>Telefonszám</label>
                        <div class="input-box">
                            <input type="text" name="phone" placeholder="+36">
                        </div>
                        <div class="error-message">Kötelező kitölteni!</div>
                    </div>
                    <label class="input-row checkbox-row">
                        <span class="checkbox">
                            <input type="checkbox" name="agree1">
                        </span>
                        <span class="text">
                            Elolvastam és megismertem az <a href="/adatkezelesi-tajekoztato" target="_blank">Adatkezelési tájékoztató</a> tartalmát.
                        </span>
                        <span class="error-message">Kötelező elfogadnia!</span>
                    </label>
                    <label class="input-row checkbox-row">
                        <span class="checkbox">
                            <input type="checkbox" name="agree2">
                        </span>
                        <span class="text">
                            Elolvastam és megismertem az <a href="/altalanos-szerzodesi-feltetelek" target="_blank">ÁSZF</a> tartalmát.
                        </span>
                        <span class="error-message">Kötelező elfogadnia!</span>
                    </label>
                    <div class="modal-button-row">
                        <button type="submit">Regisztráció</button>
                    </div>
                </form>
                <div class="modal-footer">
                    Már van fiókod? <span class="fake-link" data-close-modal="" data-show-login-modal="">Jelentkezz be!</span>
                </div>
            </div>
        </div>
    </div>
</div>