<?php

    if(!defined("SECURITY_INDEX")) die();

    class HelperFiles extends Core{



        /**
         * Download File
         *
         * Generates headers that force a download to happen
         * Example usage:
         * $file->download( 'screenshot.png', './images/screenshot.png' );
         *
         * @access public
         * @param string $filename
         * @param string $data
         * @return void
         */
        public function download( $filename = '', $data = '' )
        {
            if( $filename == '' || $data == '' )
            {
                return false;
            }

            if( !file_exists( $data ) )
            {
                return false;
            }

            // Try to determine if the filename includes a file extension.
            // We need it in order to set the MIME type
            if( false === strpos( $filename, '.' ) )
            {
                return false;
            }

            // Grab the file extension
            $extension = strtolower( pathinfo( basename( $filename ), PATHINFO_EXTENSION ) );

            // our list of mime types
            $mime_types = array(

                'txt' => 'text/plain',
                'htm' => 'text/html',
                'html' => 'text/html',
                'php' => 'text/html',
                'css' => 'text/css',
                'js' => 'application/javascript',
                'json' => 'application/json',
                'xml' => 'application/xml',
                'swf' => 'application/x-shockwave-flash',
                'flv' => 'video/x-flv',

                // images
                'png' => 'image/png',
                'jpe' => 'image/jpeg',
                'jpeg' => 'image/jpeg',
                'jpg' => 'image/jpeg',
                'gif' => 'image/gif',
                'bmp' => 'image/bmp',
                'ico' => 'image/vnd.microsoft.icon',
                'tiff' => 'image/tiff',
                'tif' => 'image/tiff',
                'svg' => 'image/svg+xml',
                'svgz' => 'image/svg+xml',

                // archives
                'zip' => 'application/zip',
                'rar' => 'application/x-rar-compressed',
                'exe' => 'application/x-msdownload',
                'msi' => 'application/x-msdownload',
                'cab' => 'application/vnd.ms-cab-compressed',

                // audio/video
                'mp3' => 'audio/mpeg',
                'qt' => 'video/quicktime',
                'mov' => 'video/quicktime',

                // adobe
                'pdf' => 'application/pdf',
                'psd' => 'image/vnd.adobe.photoshop',
                'ai' => 'application/postscript',
                'eps' => 'application/postscript',
                'ps' => 'application/postscript',

                // ms office
                'doc' => 'application/msword',
                'rtf' => 'application/rtf',
                'xls' => 'application/vnd.ms-excel',
                'ppt' => 'application/vnd.ms-powerpoint',

                // open office
                'odt' => 'application/vnd.oasis.opendocument.text',
                'ods' => 'application/vnd.oasis.opendocument.spreadsheet',
            );

            // Set a default mime if we can't find it
            if( !isset( $mime_types[$extension] ) )
            {
                $mime = 'application/octet-stream';
            }
            else
            {
                $mime = ( is_array( $mime_types[$extension] ) ) ? $mime_types[$extension][0] : $mime_types[$extension];
            }

            // Generate the server headers
            if( strstr( $_SERVER['HTTP_USER_AGENT'], "MSIE" ) )
            {
                header( 'Content-Type: "'.$mime.'"' );
                header( 'Content-Disposition: attachment; filename="'.$filename.'"' );
                header( 'Expires: 0' );
                header( 'Cache-Control: must-revalidate, post-check=0, pre-check=0' );
                header( "Content-Transfer-Encoding: binary" );
                header( 'Pragma: public' );
                header( "Content-Length: ".filesize( $data ) );
            }
            else
            {
                header( "Pragma: public" );
                header( "Expires: 0" );
                header( "Cache-Control: must-revalidate, post-check=0, pre-check=0" );
                header( "Cache-Control: private", false );
                header( "Content-Type: ".$mime, true, 200 );
                header( 'Content-Length: '.filesize( $data ) );
                header( 'Content-Disposition: attachment; filename='.$filename);
                header( "Content-Transfer-Encoding: binary" );
            }
            readfile( $data );
            exit;

        }



        // functia pentru incarcarea unui fisier pe server
        public function upload($file, $dest, $param){

        }


    }