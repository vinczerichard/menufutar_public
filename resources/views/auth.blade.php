    <!-- Login Modal -->
    <div class="modal fade" id="LoginModal">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h4 class="modal-title text-center">Bejelentkezés</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <form id="login_form">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Email</span>
                            </div>
                            <input id="post_email" type="email" name=loginemail class="form-control">
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Jelszó</span>
                            </div>
                            <input id="post_password" type="password" name=loginpass class="form-control">
                        </div>
                        <div id="login_response"></div>
                        <div id="login_verify">
                            <div class="input-group mb-3">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Megerősítő kód</span>
                                    </div>
                                    <input id="post_verify_code" type="text" name=post_verify_code
                                        class="form-control">
                                </div>
                                <button class="btn btn-outline-info btn-block" id="verify_code_resend">Kód
                                    újraküldése</button>
                            </div>
                        </div>
                        <button id="login" type="button" class="btn btn-block btn-success">Belelentkezés</button>
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-warning" id="forgot_pass"
                        data-dismiss="modal">Elfelejtett jelszó</button>
                    <button type="button" class="btn btn-outline-primary" id="reg_modal"
                        data-dismiss="modal">Regisztráció</button>
                </div>

            </div>
        </div>
    </div>
    <!-- End Login Modal -->


    <!-- Registration Modal -->
    <div class="modal fade" id="registration_modal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title w-100 text-center" id="add_modal_title">Regisztráció
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span>
                        </button>
                    </h4>
                </div>
                <div class="modal-body">
                    <form id="registration_form" name="registration_form" class="form-horizontal">
                        @csrf
                        @method('post')
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Email</span>
                            </div>
                            <input id="reg_email" type="email" name="reg_email" class="form-control" required>
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Jelszó</span>
                            </div>
                            <input id="reg_password" type="password" name="reg_pass" class="form-control" required>
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Jelszó ismét</span>
                            </div>
                            <input id="reg_password2" type="password" name="reg_pass2" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="">Körzet</label>
                            <select class="form-control" id="reg_city" name="reg_city" required>
                            </select>
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Név</span>
                            </div>
                            <input id="reg_name" type="text" name="reg_name" class="form-control" required>
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Számlázási név</span>
                            </div>
                            <input id="reg_inv_name" type="text" name="reg_inv_name" class="form-control"
                                required>
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Számla irsz.</span>
                            </div>
                            <input id="reg_inv_postal" type="text" name="reg_inv_postal" class="form-control"
                                required>
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Számla település</span>
                            </div>
                            <input id="reg_inv_city" type="text" name="reg_inv_city" class="form-control"
                                required>
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Utca, házszám</span>
                            </div>
                            <input id="reg_inv_address" type="text" name="reg_inv_address" class="form-control"
                                required>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label">
                                <input type="checkbox" id="reg_accept" name="reg_accept" class="form-check-input"
                                    value="" required>Adatkezelési tájékoztatót elolvastam és elfogadom
                            </label>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label">
                                <input type="checkbox" id="reg_subscribe" name="reg_subscribe"
                                    class="form-check-input" value="">Szeretnék feliratkozni a hírlevelekre
                                (opcionális)
                            </label>
                        </div>
                        <div id="register_response"></div>
                        <hr>
                        <div class="row">
                            <div class="col-12">
                                <button class="btn btn-success btn-block mb-3" id="registration">Regisztráció
                                </button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- End Register Modal -->
