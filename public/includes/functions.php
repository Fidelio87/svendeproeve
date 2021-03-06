<?php


function alert($type, $msg)
{
    ?>
    <div class="alert alert-<?php echo $type ?> alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
        <?php echo $msg ?>
    </div>
    <?php
}

function connect_error($line_number, $file_name)
{
    global $db;

    // If developer status is set to true, show all information
    if (DEV_STATUS) {
        die('<p>Forbindelsesfejl (' . $db->connect_errno . '): ' . $db->connect_error . '</p><p>Linje: ' .
            $line_number . '</p><p>Fil: ' . $file_name . '</p>');
    } // If developer status is set to false, only show user friendly message
    else {
        die(CONNECTION_ABORTED);
    }
}


function query_error($query, $line_number, $file_name)
{
    global $db;

    // If developer status is set to true, show all information
    if (DEV_STATUS) {
        $message =
            '<strong>' . $db->error . '</strong><br>
			Line: <strong>' . $line_number . ' </strong><br>
			File: <strong>' . $file_name . '</strong>
			<pre class="prettyprint lang-sql linenums"><code>' . $query . '</code></pre>';

        alert('danger', $message);
        $db->close();
    } else {
        alert('danger', 'Teknisk fejl!');
        $db->close();
    }
}


/**
 * @param $data
 * @param string $prefix_string
 */
function prettyprint($data, $prefix_string = '')
{
    ?>
    <pre class="prettyprint lang-php"><code><?php echo $prefix_string;
            print_r($data) ?></code></pre>
    <?php
}


function show_dev_info()
{
    // If developer status is set to true, show all information from get/post/files/session/cookie/constants
    if (DEV_STATUS) {
        echo '<br>';
        prettyprint($_GET, 'GET ');
        prettyprint($_POST, 'POST ');
        prettyprint($_FILES, 'FILES ');
        prettyprint($_SESSION, 'SESSION ');
        prettyprint($_COOKIE, 'COOKIE ');
        $consts = get_defined_constants(true);
        prettyprint($consts['user'], 'CONSTANTS ');


    }
}

/**
 * Function to create links for pagination
 * @param string $page : The name of the file in view/ the links in the pagination should refer to
 * @param int $page_no : current page no
 * @param int $items_total : the counted total amount of items
 * @param int $page_length : the desired amount of items per page
 * @param int $page_around : The desired amount of pages to show before and after the current page
 * @param bool $show_disabled_arrows : Show disabled next or previous links, or hide them
 */
function pagination($page, $page_no, $items_total, $page_length, $page_around = 2, $show_disabled_arrows = true)
{
    // Only show pagination total items is greater than page length
    if ($items_total > $page_length) {
        $pages_total = ceil($items_total / $page_length);

        // Page to start the for-loop from, at least 2 below (or what's set in page_around) the current page
        $page_from = $page_no - $page_around;

        // If current page (page_no) is in the last half of visible pages, set page_from to the total pages minus
        // page_around x2 (default 2x2) plus 2. Default page_from will be calculated to 6 below the total amount
        if ($page_no > $pages_total - $page_around * 2) {
            $page_from = $pages_total - ($page_around * 2 + 2);
        }

        // If page_from was calculated to be below 2, we start from the lowest number 2
        // (because we always have page one)
        if ($page_from < 2) {
            $page_from = 2;
        }

        // Page to end the for-loop with, at least 2 above (or what's set in page_around) the current page
        $page_to = $page_no + $page_around;

        // If current page (page_no) is in the first half of visible pages, set page_to, to page_around x2
        // (default 2x2), plus 3. Default page_to, will be calcaluted to 7
        if ($page_no <= $page_around * 2) {
            $page_to = $page_around * 2 + 3;
        }

        // If page_to was calculated to be above or equal to the total amount of pages, we end with the highest
        // number possible. One below the total number, because we always have the last page.
        if ($page_to >= $pages_total) {
            $page_to = $pages_total - 1;
        }

        echo '<ul class="pagination">';

        // If current page is greater than 1, show previous button
        if ($page_no > 1) {
            echo '<li><a href="index.php?page=' . $page . '&page-no=' . ($page_no - 1) . '" data-page="' . $page . '" data-params="page-no=' . ($page_no - 1) . '"><i class="fa fa-angle-left fa-fw" aria-hidden="true"></i></a></li>';
        } // If current page is not greater than 1 and show_disabled_arrows is set to true, show disabled previous link
        else {
            if ($show_disabled_arrows) {
                echo '<li class="disabled"><span><i class="fa fa-angle-left fa-fw" aria-hidden="true"></i></span></li>';
            }
        }

        // Show first page
        echo '<li' . ($page_no == 1 ? ' class="active"' : '') . '><a href="index.php?page=' . $page . '&page-no=1" data-page="' . $page . '" data-params="page-no=1">1</a></li>';

        // If page_from is greater than 2, we have skipped some pages, and show 3 dots
        if ($page_from > 2) {
            echo '<li class="disabled"><span>&hellip;</span></li>';
        }

        // Do for-loop, start from number in page_from, and end with the number in page_to,
        // increment with one each time the loop runs
        for ($i = $page_from; $i <= $page_to; $i++) {
            echo '<li' . ($page_no == $i ? ' class="active"' : '') . '><a href="index.php?page=' . $page . '&page-no=' . $i . '" data-page="' . $page . '" data-params="page-no=' . $i . '">' . $i . '</a></li>';
        }

        // If page_to is smaller than the second last page, we have skipped some pages in the end, so we show 3 dots
        if ($page_to < $pages_total - 1) {
            echo '<li class="disabled"><span>&hellip;</span></li>';
        }

        // Show last page
        echo '<li' . ($page_no == $pages_total ? ' class="active"' : '') . '><a href="index.php?page=' . $page . '&page-no=' . $pages_total . '" data-page="' . $page . '" data-params="page-no=' . $pages_total . '">' . $pages_total . '</a></li>';

        // If current page is smaller than pages total, show next link
        if ($page_no < $pages_total) {
            echo '<li><a href="index.php?page=' . $page . '&page-no=' . ($page_no + 1) . '" data-page="' . $page . '" data-params="page-no=' . ($page_no + 1) . '"><i class="fa fa-angle-right fa-fw" aria-hidden="true"></i></a></li>';
        } // If current page is not smaller than pages total and show_disabled_arrows is set to true,
        // show disabled next link
        else {
            if ($show_disabled_arrows) {
                echo '<li class="disabled"><span><i class="fa fa-angle-right fa-fw" aria-hidden="true"></i></span></li>';
            }
        }

        echo '</ul>';
    }
}

/**
 * Take the user agent info from the browser, add a salt and hash the information with the algo sha256
 * @return string
 */
function fingerprint()
{
    return hash('sha256', $_SERVER['HTTP_USER_AGENT'] . '!Å%bpxP-ghQæØ#_(');
}


/**
 * @param int $id
 *
 * @return bool
 */
function setUserLogin(int $id)
{
    global $db;

    $query = 'UPDATE brugere SET bruger_sidste_login = NOW() WHERE bruger_id = ' . $id;
    $result = $db->query($query);

    if (!$result) { query_error($query, __LINE__, __FILE__); }

    if ($db->affected_rows > 0) {
        set_log('info',
            'Brugeren "' . $_SESSION['bruger']['navn']  . '" med id ' . $_SESSION['bruger']['id'] . ' loggede ind',
            $_SESSION['bruger']['id']);
        return true;
    }
    return false;
}

/**
 * @param string $brugernavn
 * @param string $password
 *
 * @return bool
 */
function login(string $brugernavn, string $password)
{
    if (empty($brugernavn) || empty($password)) {
        alert('warning', 'Alle input-felter skal være udfyldte!');
    } else {
        global $db;

        $brugernavn = $db->escape_string($brugernavn);

        // Select active user that matches the typed e-mail address
        $query =
            "SELECT 
				bruger_id, bruger_brugernavn, bruger_password, rolle_niveau
			FROM 
				brugere
            INNER JOIN
                roller ON brugere.fk_rolle_id = roller.rolle_id
			WHERE 
				bruger_brugernavn = '$brugernavn' 
			AND 
				bruger_status = 1";
        $result = $db->query($query);

        if (!$result) {
            query_error($query, __LINE__, __FILE__);
        }

        if ($result->num_rows === 1) {
            $row = $result->fetch_object();

            if (password_verify($password, $row->bruger_password)) {
                session_regenerate_id();

                $_SESSION['bruger']['id']           = $row->bruger_id;
                $_SESSION['bruger']['navn']         = $row->bruger_brugernavn;
                $_SESSION['bruger']['niveau']       = $row->rolle_niveau;
                $_SESSION['fingerprint']            = fingerprint();

                setUserLogin($_SESSION['bruger']['id']);
                return true;
            }
        } else {
            alert('warning', 'Brugernavn eller password er ikke korrekt(e)!');
        }
    }
    return false;
}


/**
 * Delete the sessions from login and give the session a new id
 */
function logout()
{
    unset($_SESSION['bruger']);
    unset($_SESSION['fingerprint']);
    unset($_SESSION['last_activity']);
    // Give the current session a new id before saving user information into it
    session_regenerate_id();
}

/**
 * Function to check if the current users access level is over 100, which is equal to Admin
 * @return bool
 */
function is_admin()
{
    return $_SESSION['bruger']['niveau'] > 100 ? true : false;
}

/**
 * @param $redir | string
 */
function checkAccess(string $redir = 'index.php')
{
    global $sider;
    global $side;
    if ($_SESSION['bruger']['niveau'] < $sider[$side]['niveau']) {
        redirect_to($redir);
    }
}

/**
 * Function to check if the fingerprint stored in session, matches to current fingerprint returned from the function fingerprint()
 */
function check_fingerprint()
{
    // If the current fingerprint returned from the function doesn't match the fingerprint stored in session, logout!
    if ($_SESSION['fingerprint'] != fingerprint()) {
        logout();
        header('Location: index.php');
        exit;
    }
}

/**
 * Function to check if the user has been active within the last 30 mins
 */
function check_last_activity()
{
    // If developer status is false, use on session
    if (!DEV_STATUS) {
        // If session last activity is set and the current timestamp + 30 mins is less than current timestamp,
        // log the user out
        if (isset($_SESSION['last_activity']) && $_SESSION['last_activity'] + 1800 < time()) {
            logout();
            header('Location: index.php');
            exit;
        } // Or update the session with current timestamp
        else {
            $_SESSION['last_activity'] = time();
        }
    }
}

/**
 * @param string $string :    The text to shorten
 * @param int $chars :        The amount of characters to display of the text
 * @return string
 */
function shorten_string($string, $chars)
{
    $string = strip_tags($string);

    if (mb_strlen($string, 'utf8mb4') > $chars) {
        $last_space = strrpos(substr($string, 0, $chars + 1), ' ');
        $string = substr($string, 0, $last_space) . '&hellip;';
    }
    return $string;
}

/**
 * Function to send emails with correct header information.
 * @param string $to :        The e-mail address of the reciever of the e-mail
 * @param string $subject :    The subject of the e-mail
 * @param string $message :    The text in the e-mail
 * @param string $from :        The email address of the sender of the e-mail
 * @param string $from_name :The name of the sender of the e-mail
 * @return bool
 */
function send_mail($to, $subject, $message, $from, $from_name)
{
    // To send HTML mail, the Content-type header must be set
    $headers = "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

    // Additional headers
    $headers .= "From: " . $from_name . " <" . $from . ">\r\n";

    // Mail it
    return mail($to, $subject, $message, $headers);
}



/**
 * Short helper function for URL redirecting
 * @param null|string $location
 */
function redirect_to(string $location = null)
{
    if ($location != null) {
        header('Location: ' . $location);
        exit;
    }
}


/**
 * @param     $brugernavn
 * @param     $beskrivelse
 * @param     $password
 * @param     $conf_password
 * @param     $fil
 * @param int $rolle
 */
function opret_bruger(
    $brugernavn,
    $beskrivelse,
    $password,
    $conf_password,
    $fil,
    $rolle = 1
) {

    global $db;
    global $manager;

    if ($password !== $conf_password) {
        ?>
        <p class="text-danger">Kodeordene skal være ens!</p>
        <?php
    } else {
        //condition beskrivelse tomt
        if (empty($beskrivelse)) {
            $beskrivelse = 'WIP';
        } else {
            $beskrivelse = $db->real_escape_string($beskrivelse);
        }

//        COUNT QUERY
        $query_count = "SELECT COUNT(bruger_brugernavn) AS antal
                        FROM brugere
                        WHERE bruger_brugernavn = '$brugernavn'";

        $result_count = $db->query($query_count);
        if (!$result_count) { query_error($query_count, __LINE__, __FILE__); }
        $row_count    = $result_count->fetch_object();

        //hvis bruger m identisk brugernavn
        if ($row_count->antal > 0) {
            alert('danger', 'Brugernavnet ' .  $brugernavn . ' er desværre optaget. Prøv et nyt!');
        } else {
            //mappehenvisninger

            //gør mappen relativ alt efter frontend/backend
            if (strpos($_SERVER['REQUEST_URI'], 'admin') !== false) {
                $sti_prefix = '../';
            } else {
                $sti_prefix = '';
            }

            $img_dir = $sti_prefix . 'img/brugere/';
            $img_dir_thumbs = $sti_prefix . 'img/brugere/thumbs/';

            //check om billede er valgt og ikke er tomt
            if (isset($fil) && !empty($fil['tmp_name'])) {
                //denne variable er vigtig
                //bliver brugt i queryen
                $filnavn = time() . '_' . $db->real_escape_string($fil['name']);

                $img = $manager->make($fil['tmp_name']);

                //gemmer alm billede
                $img->resize(768, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });

                $img->save($img_dir . $filnavn);

                //gemmer thumbnail billede
                $img->resize(88, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });

                $img->save($img_dir_thumbs . $filnavn);
            } else {
                $filnavn = 'http://lorempixel.com/200/200';
            }

            //make password-hash
            $password_hashed = password_hash($password, PASSWORD_DEFAULT, HASH_COST);

            //opret insert-query
            $query = "INSERT INTO brugere (bruger_brugernavn,
                                            bruger_beskrivelse,
                                            bruger_password,
                                            bruger_img,
                                            fk_rolle_id) 
                      VALUES ('$brugernavn',
                              '$beskrivelse',
                              '$password_hashed',
                              '$filnavn',
                              $rolle)";
            $result = $db->query($query);

            $sidste_bruger_id = $db->insert_id;

            set_log('opret', 'Profil med id ' . $sidste_bruger_id . ' blev oprettet', $sidste_bruger_id);

            if ($rolle === 1) {
                $query_konto = 'INSERT INTO konti (konto_saldo, fk_bruger_id) VALUES (1500, ' . $sidste_bruger_id . ')';
                $result_konto = $db->query($query_konto);
                if (!$result_konto) { query_error($query_konto, __LINE__, __FILE__); }

                $konto_insert_id = $db->insert_id;

                set_log('opret', 'Der blev indsat 1500 grunker på en ny konto med id ' .  $konto_insert_id, 1);
            }

            if (!$result) { query_error($query, __LINE__, __FILE__); }
            ?>
            <div class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                Profil oprettet.
            </div>
            <?php
        } //.slut brugernavn-validering
    } //.slut password-validering
} //.slut - function


/**
 * @param string $kunstner
 * @param string $titel
 * @param array  $fil
 * @param int    $genre
 * @param int    $pris
 */
function opret_album(string $kunstner, string $titel, array $fil, int $genre, int $pris)
{

    global $db;
    global $manager;


    //mappehenvisninger
    $img_dir = '../img/albums/';
    $img_dir_thumbs = '../img/albums/thumbs/';


    //bliver brugt i queryen
    $filnavn = time() . '_' . $db->real_escape_string($fil['name']);

    $img = $manager->make($fil['tmp_name']);

    //gemmer alm billede
    $img->resize(200, 200);

    $img->save($img_dir . $filnavn);

    //gemmer thumbnail billede
    $img->resize(50, 50);

    $img->save($img_dir_thumbs . $filnavn);

    //opret insert-query
    $query = "INSERT INTO albums (album_kunstner, album_titel, album_img, fk_genre_id, fk_pris_id) 
              VALUES ('$kunstner', '$titel', '$filnavn', $genre, $pris)";
    $result = $db->query($query);

    if (!$result) { query_error($query, __LINE__, __FILE__); }

    ?>
    <div class="alert alert-success alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
        Album oprettet.
    </div>
    <?php

    $sidste_album_id = $db->insert_id;


    set_log('opret', 'Albummet med id ' . $sidste_album_id . ' blev oprettet');

    // TODO basic validation
}

function rediger_album(string $id, string $kunstner, string $titel, array $fil = null, int $genre, int $pris)
{

    global $db;
    global $manager;

    if (isset($fil) && !empty($fil['tmp_name'])) {
        //mappehenvisninger
        $img_dir = '../img/albums/';
        $img_dir_thumbs = '../img/albums/thumbs/';

        $query_gl_img  = 'SELECT album_id, album_img FROM albums WHERE album_id = ' . $id;
        $result_gl_img = $db->query($query_gl_img);
        $row_gl = $result_gl_img->fetch_object();
        if (!$result_gl_img) {
            query_error($query_gl_img, __LINE__, __FILE__);
        }

        if (file_exists('../img/albums/' . $row_gl->album_img) &&
            file_exists('../img/albums/thumbs' . $row_gl->album_img)) {
            unlink($img_dir . $row_gl->album_img);
            unlink($img_dir_thumbs . $row_gl->album_img);
        }

        //bliver brugt i queryen
        $filnavn = time() . '_' . $db->real_escape_string($fil['name']);

        $img_sql = ', album_img = "' . $filnavn . '"';

        $img = $manager->make($fil['tmp_name']);

        //gemmer alm billede
        $img->fit(200, 200);

        $img->save($img_dir . $filnavn);

        //gemmer thumbnail billede
        $img->fit(50, 50);

        $img->save($img_dir_thumbs . $filnavn);
    } else {
        $img_sql = '';
    }

    //opret insert-query
    $query = "UPDATE albums SET album_kunstner = '$kunstner',
                                album_titel = '$titel',
                                fk_genre_id = $genre,
                                fk_pris_id = $pris
                                $img_sql
                WHERE album_id = $id";
    $result = $db->query($query);

    if (!$result) { query_error($query, __LINE__, __FILE__); }

    ?>
    <div class="alert alert-success alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
        Album redigeret.
    </div>
    <?php

    set_log('opdater', 'Albummet med id ' . $id . ' blev redigeret');

    // TODO basic validation
}


function rediger_bruger(
    $id,
    $brugernavn,
    $fornavn,
    $efternavn,
    $beskrivelse,
    $password,
    $conf_password,
    $tlf,
    $email
)
{
    global $db;

    if ($password != $conf_password) {
        ?>
        <p class="text-warning">Password matcher ikke</p>
        <?php
    } else {
        if (empty($tlf)) {
            $tlf = 'NULL';
        } else {
            $tlf = $db->real_escape_string($tlf);
        }

        $query = "SELECT COUNT(bruger_email) AS antal
                    FROM brugere
                    WHERE bruger_email = '$email'
                    AND bruger_id != $id";
        $result = $db->query($query);
        if (!$result) { query_error($query, __LINE__, __FILE__); }

        $row = $result->fetch_object();
        if ($row->antal > 0) {
            ?>
            <p class="text-warning">Email er ikke ledig!</p>
            <?php
        } else {
            if (!empty($password)) {
                $password_hashed = password_hash($password, PASSWORD_DEFAULT);
                //sekvens til sql-statement
                $password_sql = ", bruger_password = '$password_hashed'";
            } else {
                $password_sql = '';
            }

            if (empty($beskrivelse)) {
                $beskrivelse_sql = ", bruger_beskrivelse = '$beskrivelse'";
            } else {
                $beskrivelse_sql = '';
            }

            $query = "UPDATE brugere
                        SET bruger_brugernavn = '$brugernavn',
                            bruger_fornavn = '$fornavn',
                            bruger_efternavn = '$efternavn'
                            $beskrivelse_sql
                            $password_sql,
                            bruger_tlf = $tlf,
                            bruger_email = '$email'
                        WHERE bruger_id = $id
                        ";
            $db->query($query);
            ?>
            <div class="row">
                <p class="text-success">Brugeren er nu redigeret!</p>
            </div>
            <?php
        } //.slut email-check
    } //.slut password-check
} //.slut funktion

/**
 * Password Hash Cost Calculator
 *
 * Set the ideal time that you want a password_hash() call to take and this
 * script will keep testing until it finds the ideal cost value and let you
 * know what to set it to when it has finished
 */
// Milliseconds that a hash should take (ideally)

function benchmark($password, $cost=4)
{
    $start = microtime(true);
    password_hash($password, PASSWORD_BCRYPT, ['cost'=>$cost]);
    return microtime(true) - $start;
}


/**
 * @param $filename
 *
 * @return bool
 */
function is_animated($filename)
{
    $filecontents = file_get_contents($filename);

    $str_loc = 0;
    $count = 0;
    while ($count < 2) { // There is no point in continuing after we find a 2nd frame

        $where1 = strpos($filecontents, "\x00\x21\xF9\x04", $str_loc);
        if (!$where1) {
            break;
        } else {
            $str_loc = $where1 + 1;
            $where2 = strpos($filecontents, "\x00\x2C", $str_loc);
            if (!$where2) {
                break;
            } else {
                if ($where1 + 8 == $where2) {
                    ++$count;
                }
                $str_loc = $where2 + 1;
            }
        }
    }
    return $count > 1;
}


/**
 * @param string $email
 */
function behandl_nyhedsbrev(string $email)
{
    global $db;

    $esc_email = $db->real_escape_string($email);
    $query = "SELECT tilmelding_id FROM tilmeldinger WHERE tilmelding_email = '$esc_email'";
    $result = $db->query($query);
    $antal = $result->num_rows;

    if ($antal === 1) {
        $query = "DELETE FROM tilmeldinger WHERE tilmelding_email = '$esc_email'";
        $db->query($query);
        alert('success', 'Du er nu afmeldt nyhedsbrevet');
    } else {
        $query = "INSERT INTO tilmeldinger (tilmelding_email) VALUES ('$esc_email')";
        $db->query($query);
        alert('success', 'Du er nu tilmeldt nyhedsbrevet');
    }
}


/**
 * @param string $type
 * @param string $description
 * @param int    $id
 */
function set_log(string $type, string $description, int $id)
{
    global $db;

    switch ($type) {
        case 'opret':
            $event_type_id = 1;
            break;
        case 'opdater':
            $event_type_id = 2;
            break;
        case 'slet':
            $event_type_id = 3;
            break;
            //INFO
        default:
            $event_type_id = 4;
    }

    $description    = $db->real_escape_string($description);
    if (empty($id)) {
        $id = $_SESSION['bruger']['id'];
    }

    $query = "INSERT INTO logs (log_beskrivelse, fk_bruger_id, fk_log_type) 
		      VALUES ('$description', $id, $event_type_id)";
    $result = $db->query($query);

    if (!$result) {
        query_error($query, __LINE__, __FILE__);
    }
}