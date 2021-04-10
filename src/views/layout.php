<?php
session_start();

// echo '<br /> mode : '.$error;

$title = isset($title) ? $title : null;


?>

<html lang="fr">
<head>
    <meta charset="utf-8">
    <link rel="shortcut icon" sizes="200x200" href="/public/img/favicon.ico" type="image/x-icon"/>
    <meta name="author" lang="en" content="Housni BOUDAOUD"/>
    <meta name="robots"
          content="projects, Housni, BOUDAOUD, hboudaoud, projects-boudaoud, projects-hboudaoud, cv-boudaoud, cv-hboudaoud"/>
    <meta HTTP-EQUIV="Pragma" CONTENT="no-cache"/>
    <meta name="viewport" content="width=device-width"/>
    <meta name="viewport" content="width=device-height"/>
    <meta name="viewport" content="width=device-width, initial-scale=0.9">

    <!-- Couleur du navigateur Chrom -->

    <meta name="theme-color" content="rgb(5, 45, 49)"/>
    <!-- Chrom, Firfox et opera -->
    <meta name="apple-mobile-web-app-status-bar-style" content="rgb(5, 45, 49)"/>
    <!-- Windows Phone -->
    <meta name="msapplication-navbutton-color" content="rgb(5, 45, 49)"/>
    <!-- iOS Safari -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="rgb(5, 45, 49)">

    <!-- Auto-Reactualisation de la page -->
    <!--META HTTP-EQUIV="Refresh" CONTENT="1; URL=#"-->

    <title>
        <?php echo isset($title) ? "Housni BOUDAOUD :" . $title : "Housni BOUDAOUD" ?>
    </title>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Special+Elite&display=swap" rel="stylesheet">
    <!--    <style>-->
    <!--        @import url("https://fonts.googleapis.com/css2?family=Inconsolata:wght@600&display=swap");-->
    <!--        @import url("https://fonts.googleapis.com/css2?family=Special+Elite&display=swap");-->
    <!--    </style>-->

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css"
          integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">
    <!--    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">-->
    <link rel="stylesheet" type="text/css" media="all" href="/public/css/style.css"/>
    <link rel="stylesheet" type="text/css" media="all" href="/public/css/font.css">

    <!--[if lt IE 9]>
    <script src="http://cdnjs.cloudflare.com/ajax/libs/html5shiv/r29/html5.min.js"></script>
    <style>
        html {
            background-color: rgb(110, 140, 144);
        }
    </style>
    <![endif]-->

    <script>
        if(!sessionStorage.getItem('bg_color')) {
            sessionStorage.setItem('bg_color', '36,5,116');
        }
        rgb = sessionStorage.getItem('bg_color').split(',');
		console.log('rgb',rgb[0],rgb[1],rgb[2] )
		change_document_color(rgb[0],rgb[1],rgb[2])
		

		function change_document_color(r,g,b) {		
			bg_color = r + ',' + g + ',' + b;
			btn_color = (r+g>300 ||r+b>300 || g+b>300 )?
			Math.max(255-2*r,0) + ','+ Math.max(255-2*g,0) + ',' +Math.max(255-2*b,0) 
			:(255-r) + ','+ (255-g) + ',' +(255-b);
			// btn_color = (255-r) + ','+ (255-g) + ',' +(255-b);
			sessionStorage.setItem('bg_color', bg_color);
			document.documentElement.style.setProperty("--bg-color", bg_color);
			document.documentElement.style.setProperty("--btn-color", btn_color);
			
			console.log('btn_color', btn_color, '\tbg_color', bg_color);
		}
	
		
    </script>

</head>
<body>

<?php
// echo '$foldersName : '.$directory;
    ?>
    <header>
        <!--    <nav>-->
        <!--        <ul>-->
        <!--            <li><a href="/">Home</a></li>-->
        <!--            <li><a href="/about">About</a></li>-->
        <!--            <li class="dropdown">-->
        <!--                <a href="javascript:void(0)" class="nav-btn">Projects</a>-->
        <!--                <div class="dropdown-content">-->
        <!--                    <a href="/project">All</a>-->
        <!--                    <a href="/project/new">New</a>-->
        <!--                </div>-->
        <!--            </li>-->
        <!--        </ul>-->
        <!--    </nav>-->
        <div class="container">
            <a class="nav-btn d-none" id="off-menu" href="#">
                <span class="glyphicon glyphicon-menu-right"></span>
                <span class="glyphicon glyphicon-menu-hamburger"></span>
            </a>
            <ul class="nav nav-pills d-inline" id="ul-menu">
                <li>
                    <a class="nav-btn" id="on-menu" href="#">
                        <span class="glyphicon glyphicon-menu-left"></span>
                        <span class="glyphicon glyphicon-menu-hamburger"></span>
                    </a>
                </li>
                <li><a class="nav-btn" href="/">Acceuil</a></li>
                <li><a class="nav-btn" href="/about">A propos</a></li>
                <li><a class="nav-btn" href="/contact">Contacte</a></li>
                <li><a class="nav-btn" href="/mycv">Mon CV</a></li>
                <li role="presentation" class="dropdown">
                    <a class="dropdown-toggle nav-btn" data-toggle="dropdown" href="#" role="button"
                       aria-haspopup="true"
                       aria-expanded="false">
                        Mes Projets <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="nav-btn" href="/myProjects">Liste</a></li>
                        <li><a class="nav-btn" href="/myProjects/1">project 1</a></li>
                        <li><a class="nav-btn" href="/myProjects/2">project 2</a></li>
                        <li><a class="nav-btn" href="/myProjects/3">project 3</a></li>
                    </ul>
                </li>
                <li role="presentation" class="dropdown">
                    <a class="dropdown-toggle nav-btn" data-toggle="dropdown" href="#" role="button"
                       aria-haspopup="true"
                       aria-expanded="false">
                        items <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a
                                    onclick="change_document_color(51,51,51)"
                                    style="text-align: center;
                                    padding: .1rem;
                                    background-color: rgba(51,51,51,1);
                                    color: rgba(204,204,204,1)"
                            >
                                RGB(51,51,51)
                            </a>
                        </li>
                        <li>
                            <a
                                    onclick="change_document_color(15,45,49)"
                                    style="text-align: center;
                                    padding: .1rem;
                                    background-color: rgba(15,45,49,1);
                                    color: rgba(240,210,206,1)"
                            >
                                RGB(15,45,49)
                            </a>
                        </li>
                        <li>
                            <a
                                    onclick="change_document_color(68,11,11)"
                                    style="text-align: center;
                                    padding: .1rem;
                                    background-color: rgba(68,11,11,1);
                                    color: rgba(127,244,244,1)">
                                RGB (68,11,11)
                            </a>
                        </li>
                        <li>
                        <li>
                            <a
                                    onclick="change_document_color(0,0,139)"
                                    style="text-align: center; padding: .1rem;background-color: rgba(0,0,139,1);color: rgba(255,255,116,1)">
                                RGB (0, 0, 139)
                            </a>
                        </li>
                        <li>
                            <form style="padding: .1rem;">

						<span class="small" style="padding: 0rem; background-color: rgb(15,45,49) font-size:.4rem">
						Color pickers
						<input
                                type="color" id="input_color" name="input_color" value="rgb(15,45,49)"
                        />
						</span>


                            </form>
                        </li>
                    </ul>
                </li>
                <li><a class="nav-btn" href="https://mail.hboudaoud.tk" target="_blank">mail</a></li>
            </ul>
        </div>

    </header>
<h1> <?php echo isset($title) ? $title : "Housni BOUDAOUD" ?> </h1>
<section class="container-fluid p-3">
    <?php if (isset($message->type) && isset($message->content)): ?>
        <div class="<?php echo $message->type; ?>"> <?php echo $message->content; ?></div>
    <?php endif;
    if (isset($_ENV['APP_CONTENT'])) {
        echo $_ENV['APP_CONTENT'];
    } else {
        include(__DIR__ . '/index/index.php');
    }

    ?>
    <div>
        <?php
        // include (__DIR__.'/../tools/compteur/index1.php')
        ?>
    </div>
</section>

<footer>
    <div class="row">
        <div id="afficheDate" class="col-md-3"></div>
        <div class="col-md-9">
			<?php echo isset($footer)?$footer:"Your ip adress {$_SERVER["REMOTE_ADDR"]}"?>
        </div>
    </div>
</footer>


<script src="https://code.jquery.com/jquery-1.12.4.min.js"
        integrity="sha384-nvAa0+6Qg9clwYCGGPpDQLVpLNn0fRaROjHqs13t4Ggj3Ez50XnGQqc/r8MhnRDZ"
        crossorigin="anonymous"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"
        integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd"
        crossorigin="anonymous"></script>

<script>
    $(document).ready(function () {
		$('#input_color').change(function(){			
			const result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec($(this).val());
			rgb = result 
				? {
					r: parseInt(result[1], 16),
					g: parseInt(result[2], 16),
					b: parseInt(result[3], 16)
				}
				:{r: 15,g:45,b:49};
			change_document_color(rgb.r,rgb.g,rgb.b);
		});
		$('#input_color').click(function(){			
			const result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec($(this).val());
			rgb = result 
				? {
					r: parseInt(result[1], 16),
					g: parseInt(result[2], 16),
					b: parseInt(result[3], 16)
				}
				:{r: 15,g:45,b:49};
			change_document_color(rgb.r,rgb.g,rgb.b);
			$(this).val('rgb(15,45,49)');
		});
        // let lang = "fr-FR";
        date_heure("afficheDate", "fr-FR");

        //date_heure("afficheDate");

        $("#on-menu").click(function () {
            $('#ul-menu li').toggleClass("d-none");
            $("#off-menu").toggleClass("d-none");
        });
        $("#off-menu").click(function () {
            $('#ul-menu li').toggleClass("d-none");
            $("#off-menu").toggleClass("d-none");

        });
        // $("#menu").click(function () {
        //     $('#ul-menu li').each(function (index) {
        //         $(this).toggleClass("d-none", index>0)
        //         const elementClasses = $(this).classList
        //         if (index == 0) {
        //             $(this).removeClass("menu-on").addClass("menu-off")
        //             console.log('index=0', elementClasses)
        //         } else {
        //             console.log(index, ' - index!=0', elementClasses)
        //         }
        //     });
        // });
    });
	
	

    function date_heure(id, lang) {
        //https://developer.mozilla.org/fr/docs/Web/JavaScript/Reference/Objets_globaux/DateTimeFormat/format
        const option = {
            year: 'numeric',
            month: 'long',
            weekday: 'long',
            day: 'numeric',
            hour: 'numeric',
            minute: 'numeric',
            second: 'numeric'
        };
        let date = new Date();

        document.getElementById(id).innerHTML = '<span class="glyphicon glyphicon-calendar"></span> ' +
            date.toLocaleDateString(lang, option)
                .replace(',', '<br /><span class="glyphicon glyphicon-time"></span> ');
        // console.log('date-heure', resultat);
        setTimeout('date_heure("' + id + '", "' + lang + '");', 1000);
        return true;
    }

    if ($("#mailto")) {
        $("#mailto").html("@");
    }
</script>

</body>
</html>
