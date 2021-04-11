<?php
try {
    $int1 = random_int(2, 10);
    $int2 = random_int(1, 10);
} catch (Exception $e) {
    $int1 = 10;
    $int2 = 1;
}
$sent = isset($sent)?$sent:null;
$sent->label_value_captcha = "$int1 + $int2";
$_SESSION['form_value_captcha'] = $int1 + $int2;
if (isset($message->type) && isset($message->content)): ?>
    <div style="background-color: white;">
        <div class="<?php echo $message->type; ?>" style="margin: 0"> <?php echo $message->content; ?></div>
    </div>
<?php endif;
if (isset($messageBody)): ?>
        <div class="primary" style="margin: 0" > <?php echo $messageBody; ?></div>
<?php endif; ?>


<?php if (isset($sent)): ?>

    <form
            class="perspective"
            method="post" id="contact-form" enctype="multipart/form-data">
        <div class="row">
            <div class="col-md-6">
                <div class="input-group">
                    <span class="input-group-addon">Nom :</span>
                    <input
                            id="nom"
                            type="text"
                            class="form-control"
                            name="nom"
                            placeholder="Nom"
                            value="<?php echo isset($sent->lastName) ? $sent->lastName : ''; ?>"
                            required="required"
                    />
                </div>
            </div>
            <div class="col-md-6">
                <div class="input-group">
                    <span class="input-group-addon">Prénom :</span>
                    <input
                            id="prenom"
                            type="text"
                            class="form-control"
                            name="prenom"
                            placeholder="Prénom"
                            value="<?php echo isset($sent->firstName) ? $sent->firstName : ''; ?>"
                            required="required"
                    />
                </div>
            </div>

            <div class="col-md-12 mt-5"></div>
            <div class="col-md-6">
                <div class="input-group">
                    <span class="input-group-addon">E-mail :</span>
                    <input
                            id="email"
                            type="email"
                            class="form-control"
                            name="email"
                            placeholder="E-mail"
                            value="<?php echo isset($sent->email) ? $sent->email : ''; ?>"
                            required="required"
                    />

                </div>
            </div>


            <div class="col-md-6">

                <div class="input-group">
                    <span class="input-group-addon">Sujet :</span>
                    <input
                            id="sujet"
                            type="text"
                            class="form-control"
                            name="sujet"
                            placeholder="Prénom"
                            value="<?php echo isset($sent->subject) ? $sent->subject : ''; ?>"
                    />
                </div>
            </div>
            <div class="col-md-12">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Message :</span>
                    </div>
                    <textarea
                            id="message"
                            name="message"
                            cols="400"
                            rows="4"
                            class="form-control"
                            aria-label="With textarea"
                    ><?php echo isset($sent->content) ? $sent->content : '' ?></textarea>
                </div>

            </div>
            <div class="col-md-12 mt-5"></div>
            <div class="col-md-4">

                <div class="input-group input-group-sm mt-3">
                    <span class="input-group-addon"><?php echo "{$sent->label_value_captcha} =" ?> </span>
                    <input
                            id="response-captcha"
                            type="number"
                            min="0"
                            max="20"
                            step="1"
                            class="form-control"
                            name="response-captcha"
                            placeholder="0"
                            required="required"
                    />
                    <input type="hidden" name="csrf" value="<?php echo $_SESSION['form_csrf'] ?>"/>

                </div>
            </div>
            <div class="col-md-8  m-3 text-right">

                <label for="submit"></label>
                <input id="submit" type="submit" class="nav-btn" name="contact" value="Envoyer"
                       onclick="document.getElementById(" submit").value='Téléchargement en cours, veuillez
                patienter...'">
                <input type="reset" class="nav-btn" name="effacer" value="Effacer">
            </div>
        </div>
    </form>

<?php else: ?>
    <div style="background-color: white;">
        <div class="error"  style="margin: 0">
            Form creation error
        </div>
    </div>
<?php endif; ?>
