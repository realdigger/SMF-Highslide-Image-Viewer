<?php
/**
 * @package Highslide Image Viewer Mod
 * @author digger
 * @copyright 2013
 * @license CC BY-NC-ND http://creativecommons.org/licenses/by-nc-nd/3.0/
 * @version 1.8
 */

//if (!defined('SMF'))
//    die('Hacking attempt...');

// Fix thumbnailes for some image hostings

/**
 * @param $b
 * @return mixed
 */
function highslide_fix_thumbs($b) {
    global $context;
    $context['utf8'] = true; //TODO: remove this

    if (stripos($b['domain_img'], 'imageshack') !== false && stripos($b['domain_url'], 'imageshack') !== false && preg_match('~(.*?)\.(?:th\.|)(png|gif|jp(e)?g|bmp)$~is' . ($context['utf8'] ? 'u' : ''), $b[4], $out)) {
        $out = $out[1] . '.' . $out[2];
    } elseif (stripos($b['domain_img'], 'photobucket') !== false && stripos($b['domain_url'], 'photobucket') !== false && preg_match('~(.*?)/(?:th_|)([^/]*?)\.(png|gif|jp(e)?g|bmp)$~is' . ($context['utf8'] ? 'u' : ''), $b[4], $out)) {
        $out = $out[1] . '/' . $out[2] . '.' . $out[3];
    } elseif (stripos($b['domain_img'], 'ipicture') !== false && stripos($b['domain_url'], 'ipicture') !== false && preg_match('~(.*?)/(?:thumbs|)/([^/]*?)\.(png|gif|jp(e)?g|bmp)$~is' . ($context['utf8'] ? 'u' : ''), $b[4], $out)) {
        $out = $out[1] . '/' . $out[2] . '.' . $out[3];
    } elseif (stripos($b['domain_img'], 'radikal') !== false && stripos($b['domain_url'], 'radikal') !== false && preg_match('~(.*?)/([^/]*?)t\.(png|gif|jp(e)?g|bmp)$~is' . ($context['utf8'] ? 'u' : ''), $b[4], $out)) {
        $out = $out[1] . '/' . $out[2] . '.' . $out[3];
    } elseif (stripos($b['domain_img'], 'keep4u') !== false && stripos($b['domain_url'], 'keep4u') !== false && preg_match('~(.*?)/imgs/s/(.+)\.(png|gif|jp(e)?g|bmp)$~is' . ($context['utf8'] ? 'u' : ''), $b[4], $out)) {
        $out = $out[1] . '/imgs/b/' . $out[2] . '.' . $out[3];
    } elseif (stripos($b['domain_img'], 'fotosik') !== false && stripos($b['domain_url'], 'fotosik') !== false && preg_match('~(.*?)\.(?:m\.|)(png|gif|jp(e)?g|bmp)$~is' . ($context['utf8'] ? 'u' : ''), $b[4], $out)) {
        if (substr($out[1], -1) == 'm') $out[1] = substr($out[1], 0, strlen($out[1]) - 1);
        if (substr($out[1], -3) == 'med') $out[1] = substr($out[1], 0, strlen($out[1]) - 3);
        $out = $out[1] . '.' . $out[2];
    } elseif (stripos($b['domain_img'], 'xs') !== false && stripos($b['domain_url'], 'xs') !== false && preg_match('~(.*?)\.(?:jpg.xs\.|)(png|gif|jp(e)?g|bmp)$~is' . ($context['utf8'] ? 'u' : ''), $b[4], $out)) {
        $out = $out[1] . '.' . $out[2];
    } /*
  elseif(stripos($b[4], 'MGalleryItem.php') !== false && preg_match('~(;thumb|;preview)$~is'.($context['utf8'] ? 'u' : ''), $b[4])) {
        $b[1] = str_replace($b[2], $b[2].'" class="highslide" rel="highslide', $b[1]);
    $b[1] = str_replace($b[4], str_replace(array(';preview', ';thumb'), '', $b[4]), $b[1]);
    $b[5] = str_replace('alt=""', 'alt="' . str_replace(array(';preview', ';thumb'), '', $b[4]) . '"', $b[5]); // Add filename to caption
    $b['smg'] = true;
    return $b;
  }
  */
    else return $b;

    $d = $b[1];
    $b[1] = str_replace($b[2], $out, $b[1]);
    $b[2] = $out;
    $b[5] = str_replace($d, $b[1], $b[5]);
    unset($d, $out);
    return $b;
}

// Make images highslided

/**
 * @param $message string
 * @return mixed
 */
function highslide_images($message) {
    global $context, $modSettings;
    $context['utf8'] = true; //TODO: remove this
    $modSettings['smileys_url'] = ''; //TODO: remove this

    // Grab all linked and non-linked images
    if (preg_match_all('~(<a href="([^"]*?)"(?:[^>]*?)>|)(<img src="((?!' . preg_quote($modSettings['smileys_url'], '#') . ').*?)"(?:[^>]*?)>)(?:</a>|)~ism' . ($context['utf8'] ? 'u' : ''), $message, $images, PREG_SET_ORDER)) {
        //  Output key of images - for each match
        //	0. entire match
        //	1. <a> or blank
        //	2. url or blank
        //	3. <img>
        //	4. imageurl
        //	5. Replacement string

        // Cycle through each image
        foreach ($images as $b) {
            // Match images hosted by Imageshack, Photobucket, iPicture.ru, Fotosik.pl, etc...
            $domain = @parse_url($b[4]);
            $b['domain_img'] = empty($domain['host']) ? '' : $domain['host'];

            // Non-linked images won't have all the data, so make it up
            if (empty($b[1]) && empty($b[2])
                && ((preg_match("~<img[^>]*?(width|height)[^>]*?>~ism", $b[3]))
                    || (stripos($b['domain_img'], 'imageshack') !== false && preg_match('~(.*?)\.(?:th\.|)(png|gif|jp(e)?g|bmp)$~is' . ($context['utf8'] ? 'u' : ''), $b[4]))
                    || (stripos($b['domain_img'], 'photobucket') !== false && preg_match('~(.*?)/(?:th_|)([^/]*?)\.(png|gif|jp(e)?g|bmp)$~is' . ($context['utf8'] ? 'u' : ''), $b[4]))
                    || (stripos($b['domain_img'], 'ipicture') !== false && preg_match('~(.*?)/(?:thumbs|)/([^/]*?)\.(png|gif|jp(e)?g|bmp)$~is' . ($context['utf8'] ? 'u' : ''), $b[4]))
                    || (stripos($b['domain_img'], 'radikal') !== false && preg_match('~(.*?)/([^/]*?)t\.(png|gif|jp(e)?g|bmp)$~is' . ($context['utf8'] ? 'u' : ''), $b[4]))
                    || (stripos($b['domain_img'], 'keep4u') !== false && preg_match('~(.*?)/imgs/s/(.+)\.(png|gif|jp(e)?g|bmp)$~is' . ($context['utf8'] ? 'u' : ''), $b[4]))
                    || (stripos($b['domain_img'], 'fotosik') !== false && preg_match('~(.*?)\.(?:m\.|)(png|gif|jp(e)?g|bmp)$~is' . ($context['utf8'] ? 'u' : ''), $b[4]))
                    || (stripos($b['domain_img'], 'xs') !== false && preg_match('~(.*?)\.(?:jpg.xs\.|)(png|gif|jp(e)?g|bmp)$~is' . ($context['utf8'] ? 'u' : ''), $b[4]))
                    // || (stripos($b[4], 'MGalleryItem.php') !== false && preg_match('~(thumb|preview)$~is'.($context['utf8'] ? 'u' : ''), $b[4])) // SMF Media Gallery
                )
            ) {
                $b[1] = '<a href="' . $b[4] . '">';
                $b[2] = $b[4];
                $b[5] = '<a href="' . $b[4] . '">' . $b[3] . '</a>';
            } else
                $b[5] = $b[0];

            $domain = @parse_url($b[2]);
            $b['domain_url'] = empty($domain['host']) ? '' : $domain['host'];
            $b = highslide_fix_thumbs($b);

            // Http links don't use highslide.
            if (preg_match('~\.(png|gif|jp(e)?g|bmp)$~is' . ($context['utf8'] ? 'u' : ''), $b[2])) {
                $b['domain_img'] = $b[1];
                $b[1] = str_ireplace('class="bbc_link new_win"', '', $b[1]); // Remove class="bbc_link new_win" from original <a>
                $b[1] = str_replace($b[2], $b[2] . '" class="bbc_link new_win highslide" rel="highslide', $b[1]); // Add highslide class and rel
                $b[5] = str_replace($b['domain_img'], $b[1], $b[5]);
                $b[5] = str_ireplace('alt=""', 'alt="' . $b[2] . '"', $b[5]); // Add filename to the caption
                $b[5] = $b[5] . '<div class="highslide-heading">' . (!empty($context['subject']) ? $context['subject'] : '') . '</div>'; // Add subject to the header
                $message = str_replace($b[0], $b[5], $message); // Replace the link in the message
            }
            unset($b, $domain); // Tidy up
        }
        unset($images); // Tidy up
    }

    return $message;
}
// Highslide image viewer mod *

