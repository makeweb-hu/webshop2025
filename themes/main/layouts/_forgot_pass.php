<div class="modal-window " data-forgot-password-modal="">
    <div class="modal-bg" data-close-modal=""></div>
    <div class="modal-window-content">
        <div class="modal-box">
            <div class="modal-box-header">
                <div class="modal-title">Elfelejtett jelszó</div>
                <div class="modal-close" data-close-modal="">
                    <img src="/img/dragcards/cart/close-x-dark.svg" alt="Dragcards">
                </div>
            </div>
            <div class="modal-box-content">
                <div class="modal-instructions">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla facilisi. Integer eu feugiat orci. Vestibulum id nisl id felis pharetra tincidunt. Fusce porttitor, metus a tincidunt commodo.
                </div>
                <form data-ajax-form="" data-action="/api/forgot-password" data-reset-on-success="">
                    <div class="input-row fancy-placeholder">
                        <label>E-mail cím</label>
                        <div class="input-box">
                            <input type="text" name="email" placeholder="E-mail cím">
                        </div>
                        <div class="error-message">Kötelező kitölteni!</div>
                    </div>
                    <div class="modal-button-row">
                        <button type="submit">Jelszó visszaállítása</button>
                    </div>
                </form>
                <div class="modal-footer">
                    Mégis emlékszel a jelszóra? <span class="fake-link" data-close-modal="" data-show-login-modal="">Jelentkezz be!</span>
                </div>
            </div>
        </div>
    </div>
</div>