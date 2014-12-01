<?php
/**
 * Created by Flyonweb
 * User: Double_Web
 * Date: 11/22/2014
 * Time: 01:52
 */

    class HomeController extends Core{

        public function show_home(){

            $this->view->assign("meta_title", "Framework");
            $this->view->draw('view_home');

            /*
             *  CALL LANGUAGE
             * // load language
            $this->set_lang("en", "_database");
            // read from language
            echo $this->lang->say_hello;
            */

            /*
             *  CALL CACHE
            $cache = $this->helper("cache");
            $cache->add("var1", "test");
            $value = echo $cache->get("var2");
            */

            /*
             *  CALL MODEL
            $this->model->hello();
            */

            /*
             *  CALL VIEWER
            $this->view->assign("meta_title", "Flyonweb Studio");
            $this->view->draw('view_home');
            */

            /*
             *  CALL CAPTCHA
            $captcha = $this->helper("captcha");
            $captcha->CreateImage();
            */

            /*
             *  CALL IMAGE
            $img = $this->helper("images", "imgu.jpg");
            //$img->flip('x');
            //$img->flip('y');
            //$img->rotate(70);
            //$img->desaturate();
            //$img->edges();
            $img->sepia();
            $img->save('new-image.jpg');
            */

            /*
             *  CALL EMAIL
            $mail = $this->helper("email");
            $mail->IsSMTP(); // set mailer to use SMTP
            $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = 'mihai.mihai289@gmail.com';                 // SMTP username
            $mail->Password = '123!@#qwe';                           // SMTP password
            $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 587;                                    // TCP port to connect to

            $mail->From = 'mihai.mihai289@gmail.com';
            $mail->FromName = 'Mailer';
            $mail->addAddress('mihaiz2008@yahoo.com');

            $mail->WordWrap = 50;                                 // Set word wrap to 50 characters
            $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
            $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
            $mail->isHTML(true);                                  // Set email format to HTML

            $mail->Subject = 'Here is the subject';
            $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            if(!$mail->send()) {
                echo 'Message could not be sent.';
                echo 'Mailer Error: ' . $mail->ErrorInfo;
            } else {
                echo 'Message has been sent';
            }
            */

            /*
             *  CALL FTP
                $ftp = $this->helper('ftp');
                // Opens an FTP connection to the specified host
                $ftp->connect('ftp.ed.ac.uk');
                // Login with username and password
                $ftp->login('anonymous', 'example@example.com');
                // Download file 'README' to local temporary file
                $temp = tmpfile();
                $ftp->fget($temp, 'README', HelperFtp::ASCII);
                // echo file
                echo '<pre>';
                fseek($temp, 0);
                fpassthru($temp);
             */
        }

    }