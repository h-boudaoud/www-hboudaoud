<?php


namespace Hboudaoud\Controller;


class IndexController extends AbstractController
{
    public function index(): string
    {
        return $this->render('index.php');
    }

    public function about(): string
    {
        return $this->render('index.php', ['includeFile' => '_about.php']);
    }

    public function mycv(): string
    {
        return $this->renderRedirectTo('/mycv.html');
    }

    public function contact(): string
    {
        $sent = (object)[
            'lastName' => '',
            'firstName' => '',
            'email' => '',
            'subject' => '',
            'responseCaptcha' => '',
            'form_value_captcha' => '',
            'label_value_captcha' => '',
        ];

        if (!empty($_POST)) {
            $sent->lastName = isset($_POST['nom'])
                ? stripslashes(htmlentities($_POST['nom']))
                : '';
            $sent->firstName = isset($_POST['prenom'])
                ? stripslashes(htmlentities($_POST['prenom']))
                : '';
            $sent->email = isset($_POST['email']) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)
                ? stripslashes(htmlentities($_POST['email']))
                : '';
            $sent->subject = isset($_POST['sujet']) ? stripslashes(htmlentities($_POST['sujet'])) : '';
            $sent->content = isset($_POST['message']) ? stripslashes(htmlentities($_POST['message'])) : '';
            $sent->responseCaptcha = isset($_POST['response-captcha'])
                ? stripslashes(htmlentities($_POST['response-captcha']))
                : '';
        }
        if (
            !empty($sent->lastName) &&
            !empty($sent->firstName) &&
            !empty($sent->email) &&
            !empty($sent->responseCaptcha)
        ) {
            $valueCaptcha = isset($_SESSION['form_value_captcha'])
                ? $_SESSION['form_value_captcha']
                : 0;
            $captchaIsHuman = $sent->responseCaptcha == $valueCaptcha;
            $csrfIsValid = isset($_POST['csrf']) && $_POST['csrf'] == $_SESSION['form_csrf'];


            return $this->render(
                'index.php',
                [
                    'includeFile' => '_contact.php',
                    'sent' => $sent,
                    'captchaIsHuman' => $captchaIsHuman,
                    'csrfIsValid' => $csrfIsValid
                ]
            );

        }
        $_SESSION['form_csrf'] = md5(uniqid(microtime(), true));
        return $this->render('index.php', ['includeFile' => '_contact.php', 'sent' => $sent]);

    }


}