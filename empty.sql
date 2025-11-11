-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Gép: localhost
-- Létrehozás ideje: 2025. Nov 11. 22:46
-- Kiszolgáló verziója: 8.0.30
-- PHP verzió: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Adatbázis: `dragcards`
--

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `beallitasok`
--

CREATE TABLE `beallitasok` (
  `id` int NOT NULL,
  `karbantartas_alatt` tinyint(1) NOT NULL DEFAULT '1',
  `afa` int NOT NULL DEFAULT '27',
  `karbantartas_szoveg` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci NOT NULL DEFAULT 'Az oldal jelenleg karbantartás alatt van.',
  `domain` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci NOT NULL DEFAULT 'borago.local',
  `szamlazzhu_api_kulcs` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci NOT NULL DEFAULT '97039xbwy2gws4iv7yn4xk8cniuird56tyamat6gy3',
  `szamlazzhu_elotag` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci NOT NULL DEFAULT 'TST',
  `szamlazzhu_nyugta_elotag` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci NOT NULL DEFAULT 'AA1234',
  `szamlazzhu_szamla_tipus` enum('elektronikus','papir') CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci NOT NULL DEFAULT 'elektronikus',
  `smtp_host` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci NOT NULL DEFAULT 'smtp.gmail.com',
  `smtp_username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci DEFAULT 'info@makeweb.hu',
  `smtp_password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci NOT NULL DEFAULT 'abc123',
  `smtp_port` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci NOT NULL DEFAULT '587',
  `smtp_encryption` enum('tls','ssl','none') CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci NOT NULL DEFAULT 'tls',
  `smtp_sender_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci NOT NULL DEFAULT 'Borago',
  `smtp_sender_email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci NOT NULL DEFAULT 'info@borago.hu',
  `twilio_send_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci NOT NULL DEFAULT '',
  `twilio_sid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci NOT NULL DEFAULT '',
  `twilio_token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci NOT NULL DEFAULT '',
  `twilio_message_service_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci NOT NULL DEFAULT '',
  `kozponti_telefonszam` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci DEFAULT NULL,
  `kozponti_email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci DEFAULT NULL,
  `ceg_cim_id` int DEFAULT NULL,
  `facebook_oldal` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci DEFAULT NULL,
  `email_sablon_rendeles` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci,
  `email_logo_id` int DEFAULT NULL,
  `email_lablec` text CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci,
  `email_sablon_kapcsolat` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci,
  `email_sablon_egyszeru` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_hungarian_ci;

--
-- A tábla adatainak kiíratása `beallitasok`
--

INSERT INTO `beallitasok` (`id`, `karbantartas_alatt`, `afa`, `karbantartas_szoveg`, `domain`, `szamlazzhu_api_kulcs`, `szamlazzhu_elotag`, `szamlazzhu_nyugta_elotag`, `szamlazzhu_szamla_tipus`, `smtp_host`, `smtp_username`, `smtp_password`, `smtp_port`, `smtp_encryption`, `smtp_sender_name`, `smtp_sender_email`, `twilio_send_url`, `twilio_sid`, `twilio_token`, `twilio_message_service_id`, `kozponti_telefonszam`, `kozponti_email`, `ceg_cim_id`, `facebook_oldal`, `email_sablon_rendeles`, `email_logo_id`, `email_lablec`, `email_sablon_kapcsolat`, `email_sablon_egyszeru`) VALUES
(1, 0, 27, 'Az oldal jelenleg karbantartás alatt van!', 'webshop2025.test', '97039xbwy2gws4iv7yn4xk8cniuird56tyamat6gy3', 'TST', 'AA1234', 'papir', 'smtp.gmail.com', 'info@makeweb.hu', 'tfzgwrgnlyspjpvh', '587', 'tls', 'Borago', 'info@borago.hu', '', '', '', '', '+36 30 738 6216', 'info@borago.hu', 4, 'https://www.facebook.com/boragokerteszet', '<!DOCTYPE html>\n<html lang=\"en\">\n<head>\n  <meta charset=\"utf-8\">\n  <meta name=\"viewport\" content=\"width=3Ddevice-width\">\n  <meta http-equiv=\"X-UA-Compatible\" content=\"IE=3Dedge\">\n  <meta name=\"x-apple-disable-message-reformatting\">\n  <title></title>\n\n  <!--[if mso]>\n  <style>\n    * {\n      font-family: sans-serif !important;\n    }\n  </style>\n  <![endif]-->\n\n  <!-- CSS reset -->\n  <style>\n\n    html,\n    body {\n      margin: 0 auto !important;\n      padding: 0 !important;\n      height: 100% !important;\n      width: 100% !important;\n    }\n\n    * {\n      -ms-text-size-adjust: 100%;\n      -webkit-text-size-adjust: 100%;\n    }\n\n    div[style*=\"margin: 16px 0\"] {\n      margin: 0 !important;\n    }\n\n    table,\n    td {\n      mso-table-lspace: 0pt !important;\n      mso-table-rspace: 0pt !important;\n    }\n\n    table {\n      border-spacing: 0 !important;\n      border-collapse: collapse !important;\n      table-layout: fixed !important;\n      margin: 0 auto !important;\n    }\n\n    table table table {\n      table-layout: auto;\n    }\n\n    img {\n      -ms-interpolation-mode: bicubic;\n    }\n\n    *[x-apple-data-detectors] {\n      color: inherit !important;\n      text-decoration: none !important;\n    }\n\n    .x-gmail-data-detectors,\n    .x-gmail-data-detectors *,\n    .aBn {\n      border-bottom: 0 !important;\n      cursor: default !important;\n    }\n\n    .a6S {\n      display: none !important;\n      opacity: 0.01 !important;\n    }\n\n    img.g-img + div {\n      display: none !important;\n    }\n\n    @media only screen and (min-device-width: 375px) and (max-device-width: 413px) {\n      /* iPhone 6 and 6+ */\n      .email-container {\n        min-width: 375px !important;\n      }\n    }\n\n  </style>\n\n  <!--[if gte mso 9]>\n  <xml>\n    <o:OfficeDocumentSettings>\n      <o:AllowPNG/>\n      <o:PixelsPerInch>96</o:PixelsPerInch>\n    </o:OfficeDocumentSettings>\n  </xml>\n  <![endif]-->\n\n  <!-- Progressive enhancements -->\n  <style>\n\n    body, h1, h2, h3, h4, h5, h6, p, a {\n      font-family: -apple-system, BlinkMacSystemFont, Helvetica, Arial, sans-serif;\n    }\n\n    @media screen and (max-width: 480px) {\n      .stack-column,\n      .stack-column-center {\n        display: block !important;\n        width: 100% !important;\n        max-width: 100% !important;\n        direction: ltr !important;\n      }\n\n      .stack-column-center {\n        text-align: center !important;\n      }\n\n      .center-on-narrow {\n        text-align: center !important;\n        display: block !important;\n        margin-left: auto !important;\n        margin-right: auto !important;\n        float: none !important;\n      }\n\n      table.center-on-narrow {\n        display: inline-block !important;\n      }\n    }\n\n    @media screen and (max-width: 680px) {\n      .table-border-radius {\n        border-radius: 0 !important;\n      }\n    }\n\n  </style>\n\n</head>\n<body width=\"100%\" bgcolor=\"#f3f3f3\" style=\"margin: 0; mso-line-height-rule: exactly;\">\n<div style=\"background-color: #f3f3f3\">\n\n  <!-- Visually hidden preheader text -->\n  <div style=\"display: none; font-size:1px; line-height: 1px; max-height: 0px; max-width: 0px; opacity: 0; overflow: hidden; mso-hide: all;\">\n    We\'re getting your order ready and we\'ll notify you when it\'s shipped.\n  </div>\n\n  <table role=\"presentation\" aria-hidden=\"true\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\" align=\"center\" width=\"100%\" style=\"max-width: 680px;\" class=\"email-container\">\n    <tbody>\n    <tr>\n      <td style=\"padding: 25px;\"></td>\n    </tr>\n    <tr>\n      <td bgcolor=\"#ffffff\" class=\"table-border-radius\" style=\"border-radius: 8px;\">\n\n        <table role=\"presentation\" aria-hidden=\"true\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\" align=\"center\" width=\"100%\" style=\"width: 88%; max-width: 680px;\">\n          <tr>\n            <td style=\"padding: 30px 0; text-align: center\">\n             \n               \n                <img src=\"[logo_url]\" aria-hidden=\"true\" width=\"200\"\n\n                   border=\"0\"\n                   style=\"height: auto; background: #ffffff; font-family: -apple-system, BlinkMacSystemFont, Helvetica, Arial, sans-serif; font-size: 15px; line-height: 20px;\">\n             \n            </td>\n          </tr>\n        </table>\n\n        <table role=\"presentation\" aria-hidden=\"true\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\" align=\"center\" width=\"100%\" style=\"max-width: 680px;\" class=\"email-container\">\n          <tbody>\n          <tr>\n            <td>\n              <table role=\"presentation\" aria-hidden=\"true\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\" width=\"100%\">\n                <tbody>\n                <tr>\n                  <td style=\"text-align: left; font-family:-apple-system, BlinkMacSystemFont, Helvetica, Arial, sans-serif; line-height: 1.8\">\n                    <table role=\"presentation\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"\n                      style=\"font-size:0px; width: 88% !important; min-width: 88%; max-width: 88%;\">\n                      <tbody>\n                      <tr>\n                        <td style=\"padding: 0 0 10px; color: #2f3235;\">\n                          <div style=\"font-size: 14px; color: #9ea1a3; line-height: 1.8\">\n                            Rendelés #[rendelesszam]\n                          </div>\n                          <h2 style=\"font-size: 22px; font-weight: normal; margin: 0; line-height: 1.8\">\n                            [cimsor]\n                          </h2>\n                          <div style=\"font-size:16px; color: #8e9193; margin: 0; line-height: 1.8\">\n                            [szoveg]\n                          </div>\n                        </td>\n                      </tr>\n                      </tbody>\n                    </table>\n                  </td>\n                </tr>\n                <tr>\n                  <td>\n                    <table role=\"presentation\" cellpadding=\"0\" cellspacing=\"0\" style=\"font-size:0px; width: 88% !important; min-width: 88%; max-width: 88%;\" align=\"center\" border=\"0\">\n                      <tbody>\n                      <tr>\n                        <td style=\"text-align: center; vertical-align: top; direction:ltr; font-size: 0px; padding:20px 0px;\">\n                          <div class=\"mj-column-per-100 outlook-group-fix\"\n                            style=\"vertical-align: top; display: inline-block; direction:ltr; font-size:13px; text-align:left; width:100%;\">\n                            <table role=\"presentation\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\"\n                                 border=\"0\">\n                              <tbody>\n                              <tr>\n                                <td style=\"word-break: break-word; font-size:0px;\">\n                                  <table border=\"0\" width=\"100%\">\n                                    <thead>\n                                    <tr style=\"border-bottom:1px solid #d9dcdf;\">\n                                      <th width=\"80\" style=\"padding:15px 0; text-align:left; font-family:-apple-system, BlinkMacSystemFont, Helvetica, Arial, sans-serif; font-size:16px; line-height:22px;\">\n                                        <span style=\"font-weight: normal\">Terméknév</span>\n                                      </th>\n                                      <th>\n                                         \n                                      </th>\n                                      <th style=\"padding:15px 0; text-align:right; font-family:-apple-system, BlinkMacSystemFont, Helvetica, Arial, sans-serif; font-size:16px; line-height:22px;\">\n                                        <span style=\"font-weight: normal\">Menny.</span>\n                                      </th>\n                                      <th style=\"padding:15px 0; text-align:right; font-family:-apple-system, BlinkMacSystemFont, Helvetica, Arial, sans-serif; font-size:16px; line-height:22px;\">\n                                        <span style=\"font-weight: normal\">Ár</span>\n                                      </th>\n                                    </tr>\n                                    </thead>\n                                    <tbody>\n                                   \n\n                                   \n                                      [begin:termekek]\n                                        <tr>\n                                          <td width=\"64\" style=\"vertical-align: top; padding: 10px 10px 30px 0; width: 64px;\">\n                                            <div style=\"border: 1px solid #d9dcdf; border-radius: 3px; width: 64px; height: 64px;\">\n                                              <img width=\"64\" height=\"64\" style=\"display: block;object-fit:contain;\"\n                                                src=\"[foto_url]\" />\n                                            </div>\n                                          </td>\n                                          <td style=\"padding: 10px 0 20px 0; line-height:1.5; color: #2f3235; font-family:-apple-system, BlinkMacSystemFont, Helvetica, Arial, sans-serif; font-size:16px; text-align:left;\">\n\n\n                                            [termeknev]\n\n\n                                              <div style=\"color: #8e9193\">\n                                                  [opciok]\n                                              </div>\n\n                                           \n                                          </td>\n                                          <td style=\"padding: 10px 0 20px 0; line-height: 1.5; color: #2f3235; font-family:-apple-system, BlinkMacSystemFont, Helvetica, Arial, sans-serif; font-size:16px; text-align:right;\">\n                                            [mennyiseg]\n                                          </td>\n                                          <td style=\"padding: 10px 0 20px 0; line-height: 1.5; color: #2f3235; font-family:-apple-system, BlinkMacSystemFont, Helvetica, Arial, sans-serif; font-size:16px; text-align:right;\">\n                                           \n                                              <div>[ar]</div>\n                                           \n                                           \n                                          </td>\n                                        </tr>\n                                     [end:termekek]\n                                   \n                                    </tbody>\n                                    <tfoot>\n                                    <tr style=\"border-top:1px solid #d9dcdf;\">\n                                      <td colspan=\"3\" style=\"padding: 30px 0 10px 0; text-align:right; font-family:-apple-system, BlinkMacSystemFont, Helvetica, Arial, sans-serif;font-size:16px;line-height:22px;color:#3d4246;\">\n                                        Termékek összesen\n                                      </td>\n                                      <td style=\"padding: 30px 0 10px 0;font-family:-apple-system, BlinkMacSystemFont, Helvetica, Arial, sans-serif;font-size:16px;line-height:22px;text-align:right; color:#3d4246;\">\n                                        [termekek_osszesen]\n                                      </td>\n                                    </tr>\n\n\n                                    [begin:szallitas_dija]\n                                    <tr>\n                                      <td colspan=\"3\" style=\"padding: 10px 0 10px 0;text-align:right;font-family:-apple-system, BlinkMacSystemFont, Helvetica, Arial, sans-serif;font-size:16px;line-height:22px; color:#3d4246;\">\n                                        Szállítás díja\n                                      </td>\n                                      <td style=\"padding: 10px 0 10px 0;font-family:-apple-system, BlinkMacSystemFont, Helvetica, Arial, sans-serif;font-size:16px;line-height:22px;text-align:right; color:#3d4246;\">\n                                       \n                                          [szallitas_dija]\n                                       \n                                      </td>\n                                    </tr>\n                                    [end:szallitas_dija]\n\n                                    [begin:fizetes_dija]\n                                    <tr>\n                                      <td colspan=\"3\" style=\"padding: 10px 0 10px 0;text-align:right;font-family:-apple-system, BlinkMacSystemFont, Helvetica, Arial, sans-serif;font-size:16px;line-height:22px; color:#3d4246;\">\n                                        Fizetés díja\n                                      </td>\n                                      <td style=\"padding: 10px 0 10px 0;font-family:-apple-system, BlinkMacSystemFont, Helvetica, Arial, sans-serif;font-size:16px;line-height:22px;text-align:right; color:#3d4246;\">\n\n                                        [fizetes_dija]\n\n                                      </td>\n                                    </tr>\n                                    [end:fizetes_dija]\n\n\n                                    [begin:kedvezmeny]\n                                      <tr>\n                                        <td colspan=\"3\" style=\"padding: 10px 0 10px 0;text-align:right;font-family:-apple-system, BlinkMacSystemFont, Helvetica, Arial, sans-serif;font-size:16px;line-height:22px; color:#3d4246;\">\n                                          Kedvezmény\n                                        </td>\n                                        <td width=\"200\" style=\"padding: 10px 0 10px 0;font-family:-apple-system, BlinkMacSystemFont, Helvetica, Arial, sans-serif;font-size:16px;line-height:22px;text-align:right; color:#3d4246;\">\n                                          [kedvezmeny]\n                                        </td>\n                                      </tr>\n                                   [end:kedvezmeny]\n\n                                    <tr>\n                                      <td colspan=\"3\" style=\"padding: 10px 0 30px 0;text-align:right;font-family:-apple-system, BlinkMacSystemFont, Helvetica, Arial, sans-serif;font-size:16px;line-height:22px; color:#3d4246;\">\n                                        ÁFA összesen\n                                      </td>\n                                      <td style=\"padding: 10px 0 30px 0;font-family:-apple-system, BlinkMacSystemFont, Helvetica, Arial, sans-serif;font-size:16px;line-height:22px;text-align:right; color:#3d4246;\">\n                                       \n                                          [afa_osszesen]\n                                       \n                                      </td>\n                                    </tr>\n                                    <tr style=\"border-top:1px solid #d9dcdf;\">\n                                      <td colspan=\"3\" style=\"padding: 30px 0 10px 0;text-align:right;font-family:-apple-system, BlinkMacSystemFont, Helvetica, Arial, sans-serif;font-size:16px;line-height:22px; color:#3d4246;\">\n                                        <strong>Végösszeg</strong>\n                                      </td>\n                                      <td style=\"padding: 30px 0 10px 15px; font-family:-apple-system, BlinkMacSystemFont, Helvetica, Arial, sans-serif; font-size:16px; line-height:22px; text-align:right; color:#3d4246;\">\n                                        <strong style=\"font-size: 18px; white-space: nowrap;\"> [vegosszeg]</strong>\n                                      </td>\n                                    </tr>\n                                   \n                                    </tfoot>\n                                  </table>\n                                </td>\n                              </tr>\n                              </tbody>\n                            </table>\n                          </div>\n                        </td>\n                      </tr>\n                      </tbody>\n                    </table>\n                  </td>\n                </tr>\n                <tr>\n                  <td align=\"center\" height=\"100%\" valign=\"top\" width=\"100%\" style=\"padding: 30px 0 0 0;\">\n                    <table role=\"presentation\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" align=\"center\" width=\"100%\" style=\"max-width:660px; width: 88%; padding-top: 80px;\">\n                      <tbody>\n                      <tr>\n                        <td valign=\"top\" style=\"font-size:0;\">\n                          <table role=\"presentation\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\" width=\"100%\">\n                            <tbody>\n                            <tr>\n                              <td style=\"font-family: -apple-system, BlinkMacSystemFont, Helvetica, Arial, sans-serif; font-size: 16px; line-height: 1.5; color: #8e9193; padding: 20px 0 20px 0; vertical-align: top;\" width=\"50%\" class=\"stack-column\">\n                                <div>\n                                  <strong style=\"font-weight: 600; color: #2f3235;\">\n                                    Szállítási cím\n                                  </strong>\n                                </div>\n\n                                [szallitasi_cim]\n                               \n                              </td>\n                              <td style=\"font-family: -apple-system, BlinkMacSystemFont, Helvetica, Arial, sans-serif; font-size: 16px; line-height: 1.5; color: #8e9193; padding: 20px 0 20px 0; vertical-align: top;\" width=\"50%\" class=\"stack-column\">\n                                <div>\n                                  <strong style=\"font-weight: 600; color: #2f3235;\">\n                                    Számlázási cím\n                                  </strong>\n                                </div>\n\n                                [szamlazasi_cim]\n                                 \n                               \n                              </td>\n                            </tr>\n                            </tbody>\n                          </table>\n                        </td>\n                      </tr>\n                      </tbody>\n                    </table>\n                  </td>\n                </tr>\n                <tr>\n                  <td align=\"center\" height=\"100%\" valign=\"top\" width=\"100%\" style=\"padding: 0 0 30px 0;\">\n                    <table role=\"presentation\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" align=\"center\" width=\"100%\" style=\"max-width:660px; width: 88%;\">\n                      <tbody>\n                      <tr>\n                        <td valign=\"top\" style=\"font-size:0;\">\n                          <table role=\"presentation\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\" width=\"100%\">\n                            <tbody>\n                            <tr>\n                              <td style=\"font-family: -apple-system, BlinkMacSystemFont, Helvetica, Arial, sans-serif; font-size: 16px; line-height: 1.5; color: #8e9193; padding: 20px 0 20px 0; vertical-align: top;\" width=\"50%\" class=\"stack-column\">\n                                <div>\n                                  <strong style=\"font-weight: 600; color: #2f3235;\">\n                                    Szállítási mód\n                                  </strong>\n                                </div>\n                                <div>[szallitasi_mod]</div>\n                              </td>\n                              <td style=\"font-family: -apple-system, BlinkMacSystemFont, Helvetica, Arial, sans-serif; font-size: 16px; line-height: 1.5; color: #8e9193; padding: 20px 0 20px 0; vertical-align: top;\" width=\"50%\" class=\"stack-column\">\n                                <div>\n                                  <strong style=\"font-weight: 600; color: #2f3235;\">\n                                    Fizetési mód\n                                  </strong>\n                                </div>\n                                <div>\n\n\n                                  [fizetesi_mod]\n                                   \n                                 \n                                </div>\n                              </td>\n                            </tr>\n                            </tbody>\n                          </table>\n                        </td>\n                      </tr>\n                      </tbody>\n                    </table>\n					\n					\n					<table role=\"presentation\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" align=\"center\" width=\"100%\" style=\"max-width:660px; width: 88%;\">\n                      <tbody>\n                      <tr>\n                        <td valign=\"top\" style=\"font-size:0;\">\n                          <table role=\"presentation\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\" width=\"100%\">\n                            <tbody>\n                            <tr>\n                              <td style=\"font-family: -apple-system, BlinkMacSystemFont, Helvetica, Arial, sans-serif; font-size: 16px; line-height: 1.5; color: #8e9193; padding: 20px 0 20px 0; vertical-align: top;\" width=\"50%\" class=\"stack-column\">\n                                <div>\n                                  <strong style=\"font-weight: 600; color: #2f3235;\">Vásárló adatai</strong>\n                                </div>\n                                <div>[nev]</div>\n\n<div>[email]</div><div>[telefonszam]</div>\n                              </td>\n                              \n                            </tr>\n                            </tbody>\n                          </table>\n                        </td>\n                      </tr>\n                      </tbody>\n                    </table>\n					\n                  </td>\n                </tr>\n\n                [begin:megjegyzes]\n                <tr>\n                  <td align=\"center\" height=\"100%\" valign=\"top\" width=\"100%\" style=\"padding: 0 0 30px 0;\">\n                    <table role=\"presentation\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" align=\"center\" width=\"100%\" style=\"max-width:660px; width: 88%;\">\n                      <tbody>\n                      <tr>\n                        <td align=\"left\" valign=\"top\" style=\"font-size:0;\">\n                          <table role=\"presentation\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\" width=\"100%\" style=\"margin: 0 !important; padding: 0 0 30px 0;\">\n                            <tbody>\n                            <tr>\n                              <td style=\"font-family: -apple-system, BlinkMacSystemFont, Helvetica, Arial, sans-serif; font-size: 16px; line-height: 1.5; color: #8e9193; padding: 20px 0 20px 0; vertical-align: top;\" width=\"50%\" class=\"stack-column\">\n                                <div>\n                                  <strong style=\"font-weight: 600; color: #2f3235;\">\n                                    Megjegyzés\n                                  </strong>\n                                </div>\n                                <div style=\"white-space: pre-wrap\">[megjegyzes]</div>\n                              </td>\n                            </tr>\n                            </tbody>\n                          </table>\n                        </td>\n                      </tr>\n                      </tbody>\n                    </table>\n                  </td>\n                </tr>\n                [end:megjegyzes]\n\n                [begin:fizetes_menete]\n                <tr>\n                  <td align=\"center\" height=\"100%\" valign=\"top\" width=\"100%\" style=\"padding: 0 0 30px 0;\">\n                    <table role=\"presentation\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" align=\"center\" width=\"100%\" style=\"max-width:660px; width: 88%;\">\n                      <tbody>\n                      <tr>\n                        <td align=\"left\" valign=\"top\" style=\"font-size:0;\">\n                          <table role=\"presentation\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\" width=\"100%\" style=\"margin: 0 !important; padding: 0 0 30px 0;\">\n                            <tbody>\n                            <tr>\n                              <td style=\"font-family: -apple-system, BlinkMacSystemFont, Helvetica, Arial, sans-serif; font-size: 16px; line-height: 1.5; color: #8e9193; padding: 20px 0 20px 0; vertical-align: top;\" width=\"50%\" class=\"stack-column\">\n                                <div>\n                                  <strong style=\"font-weight: 600; color: #2f3235;\">\n                                    Fizetés menete\n                                  </strong>\n                                </div>\n                                <div style=\"white-space: pre-wrap\">[fizetes_menete]</div>\n                              </td>\n                            </tr>\n                            </tbody>\n                          </table>\n                        </td>\n                      </tr>\n                      </tbody>\n                    </table>\n                  </td>\n                </tr>\n                [end:fizetes_menete]\n\n\n                </tbody>\n              </table>\n            </td>\n          </tr>\n          </tbody>\n        </table>\n\n      </td>\n    </tr>\n    </tbody>\n  </table>\n\n  <table width=\"100%\" style=\"max-width: 558px;\">\n    <tr>\n      <td style=\"font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, \'Helvetica Neue\', Arial, sans-serif; font-size: 14px; line-height: 1.5; color: #8f99ae; text-align: center; padding: 40px;\" class=\"x-gmail-data-detectors\">\n        [footer]<br />\n        <br />\n       \n      </td>\n    </tr>\n  </table>\n\n</div>\n</body>\n</html>', 1590, 'Copyright © www.borago.hu. Minden jog fentartva!', '<!DOCTYPE html>\n<html lang=\"en\"><head>\n  <meta charset=\"utf-8\">\n  <meta name=\"viewport\" content=\"width=3Ddevice-width\">\n  <meta http-equiv=\"X-UA-Compatible\" content=\"IE=3Dedge\">\n  <meta name=\"x-apple-disable-message-reformatting\">\n  <title></title>\n\n  <!--[if mso]>\n  <style>\n    * {\n      font-family: sans-serif !important;\n    }\n  </style>\n  <![endif]-->\n\n  <!-- CSS reset -->\n  <style>\n\n    html,\n    body {\n      margin: 0 auto !important;\n      padding: 0 !important;\n      height: 100% !important;\n      width: 100% !important;\n    }\n\n    * {\n      -ms-text-size-adjust: 100%;\n      -webkit-text-size-adjust: 100%;\n    }\n\n    div[style*=\"margin: 16px 0\"] {\n      margin: 0 !important;\n    }\n\n    table,\n    td {\n      mso-table-lspace: 0pt !important;\n      mso-table-rspace: 0pt !important;\n    }\n\n    table {\n      border-spacing: 0 !important;\n      border-collapse: collapse !important;\n      table-layout: fixed !important;\n      margin: 0 auto !important;\n    }\n\n    table table table {\n      table-layout: auto;\n    }\n\n    img {\n      -ms-interpolation-mode: bicubic;\n    }\n\n    *[x-apple-data-detectors] {\n      color: inherit !important;\n      text-decoration: none !important;\n    }\n\n    .x-gmail-data-detectors,\n    .x-gmail-data-detectors *,\n    .aBn {\n      border-bottom: 0 !important;\n      cursor: default !important;\n    }\n\n    .a6S {\n      display: none !important;\n      opacity: 0.01 !important;\n    }\n\n    img.g-img + div {\n      display: none !important;\n    }\n\n    @media only screen and (min-device-width: 375px) and (max-device-width: 413px) {\n      /* iPhone 6 and 6+ */\n      .email-container {\n        min-width: 375px !important;\n      }\n    }\n\n  </style>\n\n  <!--[if gte mso 9]>\n  <xml>\n    <o:OfficeDocumentSettings>\n      <o:AllowPNG/>\n      <o:PixelsPerInch>96</o:PixelsPerInch>\n    </o:OfficeDocumentSettings>\n  </xml>\n  <![endif]-->\n\n  <!-- Progressive enhancements -->\n  <style>\n\n    body, h1, h2, h3, h4, h5, h6, p, a {\n      font-family: -apple-system, BlinkMacSystemFont, Helvetica, Arial, sans-serif;\n    }\n\n    @media screen and (max-width: 480px) {\n      .stack-column,\n      .stack-column-center {\n        display: block !important;\n        width: 100% !important;\n        max-width: 100% !important;\n        direction: ltr !important;\n      }\n\n      .stack-column-center {\n        text-align: center !important;\n      }\n\n      .center-on-narrow {\n        text-align: center !important;\n        display: block !important;\n        margin-left: auto !important;\n        margin-right: auto !important;\n        float: none !important;\n      }\n\n      table.center-on-narrow {\n        display: inline-block !important;\n      }\n    }\n\n    @media screen and (max-width: 680px) {\n      .table-border-radius {\n        border-radius: 0 !important;\n      }\n    }\n\n  </style>\n\n</head>\n<body width=\"100%\" bgcolor=\"#f3f3f3\" style=\"margin: 0; mso-line-height-rule: exactly;\">\n<div style=\"background-color: #f3f3f3\">\n\n  <!-- Visually hidden preheader text -->\n  <div style=\"display: none; font-size:1px; line-height: 1px; max-height: 0px; max-width: 0px; opacity: 0; overflow: hidden; mso-hide: all;\">\n    We\'re getting your order ready and we\'ll notify you when it\'s shipped.\n  </div>\n\n  <table role=\"presentation\" aria-hidden=\"true\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\" align=\"center\" width=\"100%\" style=\"max-width: 680px;\" class=\"email-container\">\n    <tbody>\n    <tr>\n      <td style=\"padding: 25px;\"></td>\n    </tr>\n    <tr>\n      <td bgcolor=\"#ffffff\" class=\"table-border-radius\" style=\"border-radius: 8px;\">\n\n        <table role=\"presentation\" aria-hidden=\"true\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\" align=\"center\" width=\"100%\" style=\"width: 88%; max-width: 680px;\">\n          <tbody><tr>\n            <td style=\"padding: 30px 0; text-align: center\">\n             \n               \n                <img src=\"[logo_url]\" aria-hidden=\"true\" width=\"200\" border=\"0\" style=\"height: auto; background: #ffffff; font-family: -apple-system, BlinkMacSystemFont, Helvetica, Arial, sans-serif; font-size: 15px; line-height: 20px;\">\n             \n            </td>\n          </tr>\n        </tbody></table>\n\n        <table role=\"presentation\" aria-hidden=\"true\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\" align=\"center\" width=\"100%\" style=\"max-width: 680px;\" class=\"email-container\">\n          <tbody>\n          <tr>\n            <td>\n\n\n                <table role=\"presentation\" aria-hidden=\"true\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\" width=\"100%\">\n                <tbody>\n                <tr>\n                  <td style=\"text-align: left; font-family:-apple-system, BlinkMacSystemFont, Helvetica, Arial, sans-serif; line-height: 1.8\">\n                    <table role=\"presentation\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"font-size:0px; width: 88% !important; min-width: 88%; max-width: 88%;\">\n                      <tbody>\n                      <tr>\n                        <td style=\"padding: 0 0 10px; color: #2f3235;\">\n                          \n                          <h2 style=\"font-size: 22px; font-weight: normal; margin: 0; line-height: 1.8\">\n                            [cimsor]\n                          </h2>\n                          <div style=\"font-size:16px; color: #8e9193; margin: 0; line-height: 1.8\">\n                            [szoveg]\n                          </div>\n                        </td>\n                      </tr>\n                      </tbody>\n                    </table>\n                  </td>\n                </tr>\n\n\n		[begin:termek]\n                <tr>\n                  <td>\n                    <table role=\"presentation\" cellpadding=\"0\" cellspacing=\"0\" style=\"font-size:0px; width: 88% !important; min-width: 88%; max-width: 88%;\" align=\"center\" border=\"0\">\n                      <tbody>\n                      <tr>\n                        <td style=\"text-align: center; vertical-align: top; direction:ltr; font-size: 0px; padding:20px 0px;\">\n                          <div class=\"mj-column-per-100 outlook-group-fix\" style=\"vertical-align: top; display: inline-block; direction:ltr; font-size:13px; text-align:left; width:100%;\">\n                            <table role=\"presentation\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" border=\"0\">\n                              <tbody>\n                              <tr>\n                                <td style=\"word-break: break-word; font-size:0px;\">\n                                  \n                                   \n\n                                   \n\n                                    <table border=\"0\" width=\"100%\">\n                                    <thead>\n                                    <tr style=\"\">\n                                      <th width=\"80\" style=\" text-align:left; font-family:-apple-system, BlinkMacSystemFont, Helvetica, Arial, sans-serif; font-size:16px; line-height:22px;\">\n                                        <span style=\"font-weight: 600; color: #2f3235;\">Termék</span>\n                                      </th>\n                                      <th>\n                                         \n                                      </th>\n                                      \n                                      \n                                    </tr>\n                                    </thead>\n                                    <tbody><tr>\n                                          <td width=\"64\" style=\"vertical-align: top; padding: 10px 10px 30px 0; width: 64px;\">\n                                            <div style=\" border: 1px solid #d9dcdf; border-radius: 3px; width: 64px; height: 64px;\">\n                                              <img width=\"64\" height=\"64\" style=\"display: block;object-fit:contain;\" src=\"[foto_url]\">\n                                            </div>\n                                          </td>\n                                          <td style=\"padding: 10px 0 20px 0; line-height:1.5; color: #2f3235; font-family:-apple-system, BlinkMacSystemFont, Helvetica, Arial, sans-serif; font-size:16px; text-align:left;\">\n\n\n                                            [termeknev]\n\n\n                                              <div style=\"color: #8e9193\">\n                                                  [opciok]\n                                              </div>\n\n                                           \n                                          </td>\n                                          \n                                          \n                                        </tr></tbody>\n                                    \n                                  </table>\n                                </td>\n                              </tr>\n                              </tbody>\n                            </table>\n                          </div>\n                        </td>\n                      </tr>\n                      </tbody>\n                    </table>\n                  </td>\n                </tr>\n\n[end:termek]\n\n                <tr>\n                  <td align=\"center\" height=\"100%\" valign=\"top\" width=\"100%\" style=\"padding: 30px 0 0 0;\">\n                    <table role=\"presentation\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" align=\"center\" width=\"100%\" style=\"max-width:660px; width: 88%; padding-top: 80px;\">\n                      <tbody>\n                      <tr>\n                        <td valign=\"top\" style=\"font-size:0;\">\n                          <table role=\"presentation\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\" width=\"100%\">\n                            <tbody>\n                            <tr>\n                              <td style=\"font-family: -apple-system, BlinkMacSystemFont, Helvetica, Arial, sans-serif; font-size: 16px; line-height: 1.5; color: #8e9193; padding: 20px 0 20px 0; vertical-align: top;\" width=\"50%\" class=\"stack-column\">\n                                <div>\n                                  <strong style=\"font-weight: 600; color: #2f3235;\">\n                                    Név\n                                  </strong>\n                                </div>\n\n                                [nev]\n                               \n                              </td>\n                              <td style=\"font-family: -apple-system, BlinkMacSystemFont, Helvetica, Arial, sans-serif; font-size: 16px; line-height: 1.5; color: #8e9193; padding: 20px 0 20px 0; vertical-align: top;\" width=\"50%\" class=\"stack-column\">\n                                <div>\n                                  <strong style=\"font-weight: 600; color: #2f3235;\">\n                                    E-mail cím\n                                  </strong>\n                                </div>\n\n                                [email]\n                                 \n                               \n                              </td>\n                            </tr>\n                            </tbody>\n                          </table>\n                        </td>\n                      </tr>\n                      </tbody>\n                    </table>\n                  </td>\n                </tr>\n                <tr>\n                  <td align=\"center\" height=\"100%\" valign=\"top\" width=\"100%\" style=\"padding: 0 0 30px 0;\">\n                    <table role=\"presentation\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" align=\"center\" width=\"100%\" style=\"max-width:660px; width: 88%;\">\n                      <tbody>\n                      <tr>\n                        <td valign=\"top\" style=\"font-size:0;\">\n                          <table role=\"presentation\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\" width=\"100%\">\n                            <tbody>\n                            <tr>\n                              <td style=\"font-family: -apple-system, BlinkMacSystemFont, Helvetica, Arial, sans-serif; font-size: 16px; line-height: 1.5; color: #8e9193; padding: 20px 0 20px 0; vertical-align: top;\" width=\"50%\" class=\"stack-column\">\n                                <div>\n                                  <strong style=\"font-weight: 600; color: #2f3235;\">\n					Telefonszám\n                                    </strong>\n                                </div>\n                                <div>[telefon]</div>\n                              </td>\n                              \n                            </tr>\n                            </tbody>\n                          </table>\n                        </td>\n                      </tr>\n                      </tbody>\n                    </table>\n                  </td>\n                </tr><tr>\n                  <td align=\"center\" height=\"100%\" valign=\"top\" width=\"100%\" style=\"padding: 0 0 30px 0;\">\n                    <table role=\"presentation\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" align=\"center\" width=\"100%\" style=\"max-width:660px; width: 88%;\">\n                      <tbody>\n                      <tr>\n                        <td align=\"left\" valign=\"top\" style=\"font-size:0;\">\n                          <table role=\"presentation\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\" width=\"100%\" style=\"margin: 0 !important; padding: 0 0 30px 0;\">\n                            <tbody>\n                            <tr>\n                              <td style=\"font-family: -apple-system, BlinkMacSystemFont, Helvetica, Arial, sans-serif; font-size: 16px; line-height: 1.5; color: #8e9193; padding: 20px 0 20px 0; vertical-align: top;\" width=\"50%\" class=\"stack-column\">\n                                <div>\n                                  <strong style=\"font-weight: 600; color: #2f3235;\">\n                                    Üzenet\n                                  </strong>\n                                </div>\n                                <div style=\"white-space: pre-wrap\">[uzenet]</div>\n                              </td>\n                            </tr>\n                            </tbody>\n                          </table>\n                        </td>\n                      </tr>\n                      </tbody>\n                    </table>\n                  </td>\n                </tr></tbody>\n              </table>\n            </td>\n          </tr>\n          </tbody>\n        </table>\n\n      </td>\n    </tr>\n    </tbody>\n  </table>\n\n  <table width=\"100%\" style=\"max-width: 558px;\">\n    <tbody><tr>\n      <td style=\"font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, \'Helvetica Neue\', Arial, sans-serif; font-size: 14px; line-height: 1.5; color: #8f99ae; text-align: center; padding: 40px;\" class=\"x-gmail-data-detectors\">\n        [footer]<br>\n        <br>\n       \n      </td>\n    </tr>\n  </tbody></table>\n\n</div>\n\n</body></html>', '<!DOCTYPE html>\n<html lang=\"en\"><head>\n  <meta charset=\"utf-8\">\n  <meta name=\"viewport\" content=\"width=3Ddevice-width\">\n  <meta http-equiv=\"X-UA-Compatible\" content=\"IE=3Dedge\">\n  <meta name=\"x-apple-disable-message-reformatting\">\n  <title></title>\n\n  <!--[if mso]>\n  <style>\n    * {\n      font-family: sans-serif !important;\n    }\n  </style>\n  <![endif]-->\n\n  <!-- CSS reset -->\n  <style>\n\n    html,\n    body {\n      margin: 0 auto !important;\n      padding: 0 !important;\n      height: 100% !important;\n      width: 100% !important;\n    }\n\n    * {\n      -ms-text-size-adjust: 100%;\n      -webkit-text-size-adjust: 100%;\n    }\n\n    div[style*=\"margin: 16px 0\"] {\n      margin: 0 !important;\n    }\n\n    table,\n    td {\n      mso-table-lspace: 0pt !important;\n      mso-table-rspace: 0pt !important;\n    }\n\n    table {\n      border-spacing: 0 !important;\n      border-collapse: collapse !important;\n      table-layout: fixed !important;\n      margin: 0 auto !important;\n    }\n\n    table table table {\n      table-layout: auto;\n    }\n\n    img {\n      -ms-interpolation-mode: bicubic;\n    }\n\n    *[x-apple-data-detectors] {\n      color: inherit !important;\n      text-decoration: none !important;\n    }\n\n    .x-gmail-data-detectors,\n    .x-gmail-data-detectors *,\n    .aBn {\n      border-bottom: 0 !important;\n      cursor: default !important;\n    }\n\n    .a6S {\n      display: none !important;\n      opacity: 0.01 !important;\n    }\n\n    img.g-img + div {\n      display: none !important;\n    }\n\n    @media only screen and (min-device-width: 375px) and (max-device-width: 413px) {\n      /* iPhone 6 and 6+ */\n      .email-container {\n        min-width: 375px !important;\n      }\n    }\n\n  </style>\n\n  <!--[if gte mso 9]>\n  <xml>\n    <o:OfficeDocumentSettings>\n      <o:AllowPNG/>\n      <o:PixelsPerInch>96</o:PixelsPerInch>\n    </o:OfficeDocumentSettings>\n  </xml>\n  <![endif]-->\n\n  <!-- Progressive enhancements -->\n  <style>\n\n    body, h1, h2, h3, h4, h5, h6, p, a {\n      font-family: -apple-system, BlinkMacSystemFont, Helvetica, Arial, sans-serif;\n    }\n\n    @media screen and (max-width: 480px) {\n      .stack-column,\n      .stack-column-center {\n        display: block !important;\n        width: 100% !important;\n        max-width: 100% !important;\n        direction: ltr !important;\n      }\n\n      .stack-column-center {\n        text-align: center !important;\n      }\n\n      .center-on-narrow {\n        text-align: center !important;\n        display: block !important;\n        margin-left: auto !important;\n        margin-right: auto !important;\n        float: none !important;\n      }\n\n      table.center-on-narrow {\n        display: inline-block !important;\n      }\n    }\n\n    @media screen and (max-width: 680px) {\n      .table-border-radius {\n        border-radius: 0 !important;\n      }\n    }\n\n  </style>\n\n</head>\n<body width=\"100%\" bgcolor=\"#f3f3f3\" style=\"margin: 0; mso-line-height-rule: exactly;\">\n<div style=\"background-color: #f3f3f3\">\n\n  <!-- Visually hidden preheader text -->\n  <div style=\"display: none; font-size:1px; line-height: 1px; max-height: 0px; max-width: 0px; opacity: 0; overflow: hidden; mso-hide: all;\">\n    We\'re getting your order ready and we\'ll notify you when it\'s shipped.\n  </div>\n\n  <table role=\"presentation\" aria-hidden=\"true\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\" align=\"center\" width=\"100%\" style=\"max-width: 680px;\" class=\"email-container\">\n    <tbody>\n    <tr>\n      <td style=\"padding: 25px;\"></td>\n    </tr>\n    <tr>\n      <td bgcolor=\"#ffffff\" class=\"table-border-radius\" style=\"border-radius: 8px;\">\n\n        <table role=\"presentation\" aria-hidden=\"true\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\" align=\"center\" width=\"100%\" style=\"width: 88%; max-width: 680px;\">\n          <tbody><tr>\n            <td style=\"padding: 30px 0; text-align: center\">\n             \n               \n                <img src=\"[logo_url]\" aria-hidden=\"true\" width=\"200\" border=\"0\" style=\"height: auto; background: #ffffff; font-family: -apple-system, BlinkMacSystemFont, Helvetica, Arial, sans-serif; font-size: 15px; line-height: 20px;\">\n             \n            </td>\n          </tr>\n        </tbody></table>\n\n        <table role=\"presentation\" aria-hidden=\"true\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\" align=\"center\" width=\"100%\" style=\"max-width: 680px;\" class=\"email-container\">\n          <tbody>\n          <tr>\n            <td>\n\n\n                <table role=\"presentation\" aria-hidden=\"true\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\" width=\"100%\">\n                <tbody>\n                <tr>\n                  <td style=\"text-align: left; font-family:-apple-system, BlinkMacSystemFont, Helvetica, Arial, sans-serif; line-height: 1.8\">\n                    <table role=\"presentation\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"font-size:0px; width: 88% !important; min-width: 88%; max-width: 88%;\">\n                      <tbody>\n                      <tr>\n                        <td style=\"padding: 0 0 10px; color: #2f3235;\">\n                          \n                          <h2 style=\"font-size: 22px; font-weight: normal; margin: 0; line-height: 1.8\">\n                            [cimsor]\n                          </h2>\n                          <div style=\"font-size:16px; color: #8e9193; margin: 0; line-height: 1.8\">\n                            [szoveg] <br/><br/>\n                          </div>\n\n                        </td>\n                      </tr>\n                      </tbody>\n                    </table>\n                  </td>\n                </tr>\n\n\n		\n                \n\n\n                \n                </tbody>\n              </table>\n            </td>\n          </tr>\n          </tbody>\n        </table>\n\n      </td>\n    </tr>\n    </tbody>\n  </table>\n\n  <table width=\"100%\" style=\"max-width: 558px;\">\n    <tbody><tr>\n      <td style=\"font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, \'Helvetica Neue\', Arial, sans-serif; font-size: 14px; line-height: 1.5; color: #8f99ae; text-align: center; padding: 40px;\" class=\"x-gmail-data-detectors\">\n        [footer]<br>\n        <br>\n       \n      </td>\n    </tr>\n  </tbody></table>\n\n</div>\n\n</body></html>');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `bejelentkezes_2fa`
--

CREATE TABLE `bejelentkezes_2fa` (
  `id` int NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci NOT NULL,
  `letrehozva` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `felhasznalo_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_hungarian_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `cim`
--

CREATE TABLE `cim` (
  `id` int NOT NULL,
  `nev` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci NOT NULL,
  `iranyitoszam` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci NOT NULL,
  `orszag_id` int NOT NULL,
  `telepules` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci NOT NULL,
  `utca` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci NOT NULL DEFAULT '',
  `ceges` tinyint(1) NOT NULL DEFAULT '0',
  `adoszam` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci DEFAULT NULL,
  `megjegyzes` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_hungarian_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `egyseg`
--

CREATE TABLE `egyseg` (
  `id` int NOT NULL,
  `nev` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci NOT NULL,
  `rovid_nev` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_hungarian_ci;

--
-- A tábla adatainak kiíratása `egyseg`
--

INSERT INTO `egyseg` (`id`, `nev`, `rovid_nev`) VALUES
(1, 'Darab', 'db');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `email_sablon`
--

CREATE TABLE `email_sablon` (
  `id` int NOT NULL,
  `nev` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci NOT NULL,
  `cimsor` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci DEFAULT NULL,
  `targy` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci NOT NULL,
  `szoveg` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci,
  `sablon` enum('egyszeru','megrendeles','kapcsolat') CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci DEFAULT 'egyszeru'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_hungarian_ci;

--
-- A tábla adatainak kiíratása `email_sablon`
--

INSERT INTO `email_sablon` (`id`, `nev`, `cimsor`, `targy`, `szoveg`, `sablon`) VALUES
(1, 'Új megrendelés', 'Köszönjük a megrendelést!', '[rendelesszam] számú rendelés értesítő', '<p>Megrendelését megkaptuk, hamarosan felvesszük Önnel a kapcsolatot.</p>', 'megrendeles'),
(2, 'Új megrendelés (adminnak)', 'Új megrendelés', '[rendelesszam] számú rendelés értesítő', 'Az alábbi adatokkal új megrendelés érkezett be.', 'megrendeles'),
(3, 'Kapcsolatfelvétel (adminnak)', 'Új kapcsolatfelvétel történt', 'Üzenet a weboldalról', 'Az alábbi adatokkal új kapcsolatfelvétel történt.', 'kapcsolat'),
(4, 'Megrendelés átvehető', 'Megrendelése átvehető', '[rendelesszam] megrendelése átvehető', '<p>Megrendelését átveheti bemutatókertünkben, az alábbi címen:</p>\r\n<p>4551 Nyíregyháza, Fő u. 29.</p>', 'megrendeles'),
(5, 'Megrendelését átadtuk a futárszolgálatnak', 'Megrendelését átadtuk a futárszolgálatnak', '[rendelesszam] megrendelését átadtuk a futárszolgálatnak', '<p>Megrendelését átadtuk a GLS futárszolgálatnak. A kiszállítás nyomon követésével kapcsolatban a GLS fog Önnek értesítőt küldeni.</p>', 'megrendeles'),
(6, 'Rendelés nyomtatási nézet', '[rendelesszam] számú rendelés', '[rendelesszam] számú rendelés', '', 'megrendeles'),
(7, 'Megrendelését töröltük', 'Megrendelését töröltük', '[rendelesszam] megrendelését töröltük', '', 'megrendeles'),
(8, 'Megrendelését módosítottuk', 'Megrendelését módosítottuk', '[rendelesszam] megrendelését módosítottuk', 'Megrendelésének adatait módosítottuk az alábbiak szerint. Kérjük, nézze át az adatok helyességét!', 'megrendeles');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `fajl`
--

CREATE TABLE `fajl` (
  `id` int NOT NULL,
  `fajlnev` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci NOT NULL DEFAULT '',
  `feltoltve` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `sha1` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci DEFAULT NULL,
  `cegnev` int DEFAULT NULL,
  `felhasznalo_id` int DEFAULT NULL,
  `meret` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_hungarian_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `felhasznalo`
--

CREATE TABLE `felhasznalo` (
  `id` int NOT NULL,
  `nev` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci NOT NULL,
  `jogosultsag` enum('superadmin','admin','moderator') CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci NOT NULL DEFAULT 'admin',
  `letrehozva` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `jelszo_hash` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci DEFAULT NULL,
  `profilkep_id` int DEFAULT NULL,
  `ketfaktoros_kulcs` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci DEFAULT NULL,
  `ertesites` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_hungarian_ci;

--
-- A tábla adatainak kiíratása `felhasznalo`
--

INSERT INTO `felhasznalo` (`id`, `nev`, `email`, `jogosultsag`, `letrehozva`, `jelszo_hash`, `profilkep_id`, `ketfaktoros_kulcs`, `ertesites`) VALUES
(1, 'Makeweb Admin', 'info@makeweb.hu', 'superadmin', '2023-04-12 23:40:59', '$2y$10$7WzCn8UhV5jCw16lnBkeZO5Id2NHQF9bppQzDS70lFw/jmbL3I9Oi', 1589, NULL, 1);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `felhasznalo_naplo`
--

CREATE TABLE `felhasznalo_naplo` (
  `id` int NOT NULL,
  `letrehozva` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `felhasznalo_id` int NOT NULL,
  `parameterek` json DEFAULT NULL,
  `tipus` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci DEFAULT NULL,
  `leiras` text CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_hungarian_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `fizetes`
--

CREATE TABLE `fizetes` (
  `id` int NOT NULL,
  `nev` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci NOT NULL,
  `ar` int DEFAULT NULL,
  `szolgaltato` enum('stripe','') CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci DEFAULT NULL,
  `fizetesi_instrukcio` text CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci,
  `leiras` varchar(512) CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci NOT NULL DEFAULT '',
  `megnevezes_szamlan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci DEFAULT NULL,
  `utanvet` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_hungarian_ci;

--
-- A tábla adatainak kiíratása `fizetes`
--

INSERT INTO `fizetes` (`id`, `nev`, `ar`, `szolgaltato`, `fizetesi_instrukcio`, `leiras`, `megnevezes_szamlan`, `utanvet`) VALUES
(1, 'Készpénz', 0, 'stripe', '', 'A csomag árát személyesen, az átvételkor kell fizetni.', 'KP', 0),
(2, 'Online bankkártyás fizetés', 0, 'stripe', '', 'Stripe leírás ide', '', 1),
(3, 'Utánvét', 300, '', '', 'utánvét leírás ide', NULL, 0),
(4, 'Előre utalás', NULL, '', '', '', '', 0);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `hir`
--

CREATE TABLE `hir` (
  `id` int NOT NULL,
  `cim` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci NOT NULL,
  `kategoria_id` int DEFAULT NULL,
  `bevezeto` text CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci,
  `tartalom` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci,
  `publikalas_datuma` date DEFAULT NULL,
  `kep_id` int DEFAULT NULL,
  `nyelv` enum('hu','en','de','sk','cz','pl','ro') CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci NOT NULL,
  `meta_cim` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci DEFAULT NULL,
  `meta_leiras` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci DEFAULT NULL,
  `meta_kep_id` int DEFAULT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci NOT NULL,
  `statusz` enum('piszkozat','publikalva','inaktiv') CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci NOT NULL DEFAULT 'piszkozat',
  `letrehozva` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modositva` datetime DEFAULT NULL,
  `kiemelt` tinyint(1) NOT NULL DEFAULT '0',
  `oldal_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_hungarian_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `hir_kategoria`
--

CREATE TABLE `hir_kategoria` (
  `id` int NOT NULL,
  `nev_hu` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci DEFAULT NULL,
  `nev_en` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci DEFAULT NULL,
  `nev_de` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci DEFAULT NULL,
  `nev_sk` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci DEFAULT NULL,
  `nev_cz` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci DEFAULT NULL,
  `nev_pl` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci DEFAULT NULL,
  `nev_ro` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci DEFAULT NULL,
  `meta_cim_hu` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci DEFAULT NULL,
  `meta_cim_en` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci DEFAULT NULL,
  `meta_cim_de` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci DEFAULT NULL,
  `meta_cim_sk` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci DEFAULT NULL,
  `meta_cim_cz` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci DEFAULT NULL,
  `meta_cim_pl` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci DEFAULT NULL,
  `meta_cim_ro` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci DEFAULT NULL,
  `meta_leiras_hu` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci DEFAULT NULL,
  `meta_leiras_en` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci DEFAULT NULL,
  `meta_leiras_de` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci DEFAULT NULL,
  `meta_leiras_sk` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci DEFAULT NULL,
  `meta_leiras_cz` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci DEFAULT NULL,
  `meta_leiras_ro` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci DEFAULT NULL,
  `meta_leiras_pl` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci DEFAULT NULL,
  `meta_kep_id` int DEFAULT NULL,
  `slug_hu` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci DEFAULT NULL,
  `slug_en` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci DEFAULT NULL,
  `slug_de` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci DEFAULT NULL,
  `slug_cz` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci DEFAULT NULL,
  `slug_sk` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci DEFAULT NULL,
  `slug_pl` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci DEFAULT NULL,
  `slug_ro` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_hungarian_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `kapcsolat`
--

CREATE TABLE `kapcsolat` (
  `id` int NOT NULL,
  `nev` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci DEFAULT NULL,
  `telefonszam` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci DEFAULT NULL,
  `uzenet` text CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci,
  `idopont` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `termek_id` int DEFAULT NULL,
  `variacio_id` int DEFAULT NULL,
  `megtekintve` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_hungarian_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `kategoria`
--

CREATE TABLE `kategoria` (
  `id` int NOT NULL,
  `nev` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci NOT NULL,
  `szulo_id` int DEFAULT NULL,
  `foto_id` int DEFAULT NULL,
  `oldal_id` int DEFAULT NULL,
  `sorrend` int DEFAULT NULL,
  `lokalis_sorrend` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_hungarian_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `kosar`
--

CREATE TABLE `kosar` (
  `id` int NOT NULL,
  `nev` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci DEFAULT NULL,
  `telefonszam` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci DEFAULT NULL,
  `idopont` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci NOT NULL,
  `parameterek` json DEFAULT NULL,
  `megrendelve` tinyint(1) NOT NULL DEFAULT '0',
  `fizetes_id` int DEFAULT NULL,
  `szallitas_id` int DEFAULT NULL,
  `megjegyzes` varchar(1024) CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci NOT NULL DEFAULT '',
  `vasarlo_id` int DEFAULT NULL,
  `afa` int NOT NULL,
  `szallitasi_cim_id` int DEFAULT NULL,
  `szamlazasi_cim_id` int DEFAULT NULL,
  `rendelesszam` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci DEFAULT NULL,
  `kupon_id` int DEFAULT NULL,
  `szallitasi_dij` int DEFAULT NULL,
  `fizetesi_dij` int DEFAULT NULL,
  `kedvezmeny` int DEFAULT NULL,
  `email_logo_id` int DEFAULT NULL,
  `szallitasi_dij_afa` int DEFAULT NULL,
  `fizetesi_dij_afa` int DEFAULT NULL,
  `kedvezmeny_hatasa` enum('termekek','szallitasi_dij','vegosszeg') CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci DEFAULT NULL,
  `kedvezmeny_afa` int DEFAULT NULL,
  `fizetve` tinyint(1) NOT NULL DEFAULT '0',
  `statusz` enum('nincs_teljesitve','atveheto','kiszallitas_alatt','teljesitve','elvetve','adatok_modositva') CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci NOT NULL DEFAULT 'nincs_teljesitve',
  `megrendeles_idopontja` datetime DEFAULT NULL,
  `csomagszam` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_hungarian_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `kosar_kedveles`
--

CREATE TABLE `kosar_kedveles` (
  `id` int NOT NULL,
  `kosar_id` int NOT NULL,
  `termek_id` int DEFAULT NULL,
  `variacio_id` int DEFAULT NULL,
  `idopont` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_hungarian_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `kosar_tetel`
--

CREATE TABLE `kosar_tetel` (
  `id` int NOT NULL,
  `kosar_id` int NOT NULL,
  `mennyiseg` int NOT NULL,
  `idopont` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `termek_id` int NOT NULL,
  `variacio_id` int DEFAULT NULL,
  `opciok` json DEFAULT NULL,
  `egysegar` int DEFAULT NULL,
  `afa` int DEFAULT NULL,
  `termeknev` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_hungarian_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `kupon`
--

CREATE TABLE `kupon` (
  `id` int NOT NULL,
  `kod` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci NOT NULL,
  `ervenyesseg_kezdete` date DEFAULT NULL,
  `ervenyesseg_vege` date DEFAULT NULL,
  `kedvezmeny_hatasa` enum('termekek','szallitasi_dij','vegosszeg') CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci NOT NULL,
  `kedvezmeny_tipusa` enum('szazalek','fix_osszeg') CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci NOT NULL,
  `kedvezmeny_merteke` int NOT NULL,
  `statusz` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_hungarian_ci;

--
-- A tábla adatainak kiíratása `kupon`
--

INSERT INTO `kupon` (`id`, `kod`, `ervenyesseg_kezdete`, `ervenyesseg_vege`, `kedvezmeny_hatasa`, `kedvezmeny_tipusa`, `kedvezmeny_merteke`, `statusz`) VALUES
(1, 'MAKEWEB64', NULL, NULL, 'termekek', 'szazalek', 20, 1),
(2, 'TESZT', NULL, NULL, 'szallitasi_dij', 'fix_osszeg', 200, 0);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `munkamenet`
--

CREATE TABLE `munkamenet` (
  `id` int NOT NULL,
  `felhasznalo_id` int DEFAULT NULL,
  `letrehozva` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_hungarian_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `oldal`
--

CREATE TABLE `oldal` (
  `id` int NOT NULL,
  `kep_id` int DEFAULT NULL,
  `cim` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci NOT NULL DEFAULT '',
  `leiras` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci NOT NULL DEFAULT '',
  `url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci NOT NULL,
  `tipus` enum('termek','tartalom','kategoria','atiranyitas','statikus_oldal','hir') CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci NOT NULL,
  `model_id` int DEFAULT NULL,
  `atiranyitas_statusz` int DEFAULT NULL,
  `hova` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_hungarian_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `orszag`
--

CREATE TABLE `orszag` (
  `id` int NOT NULL,
  `nev` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_hungarian_ci;

--
-- A tábla adatainak kiíratása `orszag`
--

INSERT INTO `orszag` (`id`, `nev`) VALUES
(1, 'Magyarország');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `promocio`
--

CREATE TABLE `promocio` (
  `id` int NOT NULL,
  `tipus` enum('termek','szallitasi_dij') CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci NOT NULL,
  `ervenyesseg_kezdete` date DEFAULT NULL,
  `ervenyesseg_vege` date DEFAULT NULL,
  `minimum_osszeg` int DEFAULT NULL,
  `kedvezmeny_tipusa` enum('szazalek','fix_osszeg') CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci NOT NULL,
  `kedvezmeny_merteke` int NOT NULL,
  `kategoria_id` int DEFAULT NULL,
  `statusz` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_hungarian_ci;

--
-- A tábla adatainak kiíratása `promocio`
--

INSERT INTO `promocio` (`id`, `tipus`, `ervenyesseg_kezdete`, `ervenyesseg_vege`, `minimum_osszeg`, `kedvezmeny_tipusa`, `kedvezmeny_merteke`, `kategoria_id`, `statusz`) VALUES
(3, 'termek', '2023-07-01', '2023-11-30', NULL, 'szazalek', 50, 72, 1);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `slider`
--

CREATE TABLE `slider` (
  `id` int NOT NULL,
  `cim` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci NOT NULL,
  `leiras` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci NOT NULL,
  `link` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci NOT NULL,
  `sorrend` int DEFAULT NULL,
  `kep_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_hungarian_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `statikus_oldal`
--

CREATE TABLE `statikus_oldal` (
  `id` int NOT NULL,
  `oldal_id` int DEFAULT NULL,
  `cim` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci NOT NULL,
  `tartalom` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci,
  `megjelenes` enum('sehol','fejlec','lablec') CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci DEFAULT 'sehol',
  `statusz` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_hungarian_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `statikus_szoveg`
--

CREATE TABLE `statikus_szoveg` (
  `id` int NOT NULL,
  `nev` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci NOT NULL,
  `tartalom_hu` text CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci,
  `tartalom_en` text CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci,
  `tartalom_de` text CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci,
  `tipus` enum('rovid_szoveg','hosszu_szoveg','formazott_szoveg','fajl','html') CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci NOT NULL DEFAULT 'rovid_szoveg'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_hungarian_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `szallitas`
--

CREATE TABLE `szallitas` (
  `id` int NOT NULL,
  `nev` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci NOT NULL,
  `ar` int DEFAULT NULL,
  `statusz` tinyint(1) NOT NULL DEFAULT '1',
  `sorrend` int DEFAULT NULL,
  `szolgaltato` enum('gls','') CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci DEFAULT NULL,
  `leiras` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_hungarian_ci;

--
-- A tábla adatainak kiíratása `szallitas`
--

INSERT INTO `szallitas` (`id`, `nev`, `ar`, `statusz`, `sorrend`, `szolgaltato`, `leiras`) VALUES
(1, 'GLS futárszolgálat (utánvét)', 2690, 1, NULL, 'gls', 'A csomag árát személyesen, az átvételkor kell fizetni,'),
(2, 'GLS futárszolgálat (előre utalással)', 2200, 1, NULL, 'gls', 'A csomag ellenértékét átutalással kell teljesíteni. ERSTE BANK : 11600006-00000000-97591612'),
(3, 'Személyes átvétel bemutatókertünkben', 0, 1, NULL, '', 'Személyes átvétel bemutatókertünkben.');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `szallitas_fizetes`
--

CREATE TABLE `szallitas_fizetes` (
  `id` int NOT NULL,
  `szallitas_id` int NOT NULL,
  `fizetes_id` int NOT NULL,
  `sorrend` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_hungarian_ci;

--
-- A tábla adatainak kiíratása `szallitas_fizetes`
--

INSERT INTO `szallitas_fizetes` (`id`, `szallitas_id`, `fizetes_id`, `sorrend`) VALUES
(24, 1, 3, NULL),
(25, 2, 4, NULL),
(28, 3, 1, NULL);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `szamla`
--

CREATE TABLE `szamla` (
  `id` int NOT NULL,
  `bizonylatszam` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci NOT NULL,
  `idopont` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `szamlazo` enum('szamlazzhu','billingo') CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci NOT NULL,
  `sztorno` tinyint(1) NOT NULL DEFAULT '0',
  `sztornozott_bizonylat` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci DEFAULT NULL,
  `kosar_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_hungarian_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `tartalom`
--

CREATE TABLE `tartalom` (
  `id` int NOT NULL,
  `tipus` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci NOT NULL,
  `sorrend` int DEFAULT NULL,
  `adatok` json DEFAULT NULL,
  `kereses` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_hungarian_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `termek`
--

CREATE TABLE `termek` (
  `id` int NOT NULL,
  `nev` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci NOT NULL,
  `cikkszam` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci DEFAULT NULL,
  `oldal_id` int DEFAULT NULL,
  `foto_id` int DEFAULT NULL,
  `ar` int DEFAULT NULL,
  `akcios` tinyint(1) NOT NULL DEFAULT '0',
  `akcio_tipusa` enum('szazalek','fix_ar') CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci DEFAULT NULL,
  `akcios_ar` int DEFAULT NULL,
  `akcio_szazalek` int DEFAULT NULL,
  `rovid_leiras` text CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci,
  `leiras` text CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci,
  `afa` int NOT NULL DEFAULT '27',
  `statusz` tinyint(1) NOT NULL DEFAULT '1',
  `kategoria_id` int DEFAULT NULL,
  `keszlet` int DEFAULT NULL,
  `keszlet_info` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci NOT NULL DEFAULT '',
  `egyseg_id` int DEFAULT NULL,
  `ujdonsag` tinyint(1) NOT NULL DEFAULT '0',
  `foto_1` int DEFAULT NULL,
  `foto_2` int DEFAULT NULL,
  `foto_3` int DEFAULT NULL,
  `foto_4` int DEFAULT NULL,
  `foto_5` int DEFAULT NULL,
  `foto_6` int DEFAULT NULL,
  `foto_7` int DEFAULT NULL,
  `foto_8` int DEFAULT NULL,
  `foto_9` int DEFAULT NULL,
  `foto_10` int DEFAULT NULL,
  `letrehozva` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_hungarian_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `termekajanlo`
--

CREATE TABLE `termekajanlo` (
  `id` int NOT NULL,
  `termek_id` int NOT NULL,
  `masik_termek_id` int NOT NULL,
  `sorrend` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_hungarian_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `termek_tulajdonsag`
--

CREATE TABLE `termek_tulajdonsag` (
  `id` int NOT NULL,
  `termek_id` int NOT NULL,
  `tulajdonsag_id` int NOT NULL,
  `ertek_id` int DEFAULT NULL,
  `ertek_file` int DEFAULT NULL,
  `ertek_num` double DEFAULT NULL,
  `ertek_str` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_hungarian_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `termek_tulajdonsag_ertek`
--

CREATE TABLE `termek_tulajdonsag_ertek` (
  `id` int NOT NULL,
  `termek_tulajdonsag_id` int NOT NULL,
  `tulajdonsag_opcio_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_hungarian_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `tulajdonsag`
--

CREATE TABLE `tulajdonsag` (
  `id` int NOT NULL,
  `nev` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci NOT NULL,
  `ertek_tipus` enum('bool','string','number','select','multiselect','file') CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci NOT NULL,
  `szurheto` tinyint(1) NOT NULL DEFAULT '0',
  `lathato` tinyint(1) NOT NULL DEFAULT '0',
  `kotelezo` tinyint(1) NOT NULL DEFAULT '0',
  `variaciokepzo` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_hungarian_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `tulajdonsag_opcio`
--

CREATE TABLE `tulajdonsag_opcio` (
  `id` int NOT NULL,
  `tulajdonsag_id` int DEFAULT NULL,
  `ertek` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci NOT NULL,
  `sorrend` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_hungarian_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `variacio`
--

CREATE TABLE `variacio` (
  `id` int NOT NULL,
  `termek_id` int NOT NULL,
  `opcio_1` int DEFAULT NULL,
  `opcio_2` int DEFAULT NULL,
  `opcio_3` int DEFAULT NULL,
  `opcio_4` int DEFAULT NULL,
  `opcio_5` int DEFAULT NULL,
  `foto_id` int DEFAULT NULL,
  `ar` int DEFAULT NULL,
  `akcios` tinyint(1) NOT NULL DEFAULT '0',
  `akcio_tipusa` enum('szazalek','fix_ar') CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci DEFAULT NULL,
  `akcios_ar` int DEFAULT NULL,
  `akcio_szazalek` int DEFAULT NULL,
  `statusz` tinyint(1) NOT NULL DEFAULT '1',
  `keszlet` int DEFAULT NULL,
  `keszlet_info` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci DEFAULT NULL,
  `nev` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci DEFAULT NULL,
  `cikkszam` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_hungarian_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `vasarlo`
--

CREATE TABLE `vasarlo` (
  `id` int NOT NULL,
  `nev` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci NOT NULL,
  `telefonszam` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci DEFAULT NULL,
  `szallitasi_cim_id` int DEFAULT NULL,
  `szamlazasi_cim_id` int DEFAULT NULL,
  `jelszo_hash` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci DEFAULT NULL,
  `megjegyzes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci,
  `email_marketing` tinyint(1) NOT NULL DEFAULT '0',
  `letrehozas_idopontja` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_hungarian_ci;

--
-- Indexek a kiírt táblákhoz
--

--
-- A tábla indexei `beallitasok`
--
ALTER TABLE `beallitasok`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ceg_cim_id` (`ceg_cim_id`),
  ADD KEY `email_logo_id` (`email_logo_id`);

--
-- A tábla indexei `bejelentkezes_2fa`
--
ALTER TABLE `bejelentkezes_2fa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `felhasznalo_id` (`felhasznalo_id`);

--
-- A tábla indexei `cim`
--
ALTER TABLE `cim`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orszag_id` (`orszag_id`);

--
-- A tábla indexei `egyseg`
--
ALTER TABLE `egyseg`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `email_sablon`
--
ALTER TABLE `email_sablon`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `fajl`
--
ALTER TABLE `fajl`
  ADD PRIMARY KEY (`id`),
  ADD KEY `felhasznalo_id` (`felhasznalo_id`);

--
-- A tábla indexei `felhasznalo`
--
ALTER TABLE `felhasznalo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `profilkep_id` (`profilkep_id`);

--
-- A tábla indexei `felhasznalo_naplo`
--
ALTER TABLE `felhasznalo_naplo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `felhasznalo_id` (`felhasznalo_id`);

--
-- A tábla indexei `fizetes`
--
ALTER TABLE `fizetes`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `hir`
--
ALTER TABLE `hir`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `kategoria_id` (`kategoria_id`);

--
-- A tábla indexei `hir_kategoria`
--
ALTER TABLE `hir_kategoria`
  ADD PRIMARY KEY (`id`),
  ADD KEY `meta_kep_id` (`meta_kep_id`);

--
-- A tábla indexei `kapcsolat`
--
ALTER TABLE `kapcsolat`
  ADD PRIMARY KEY (`id`),
  ADD KEY `termek_id` (`termek_id`),
  ADD KEY `variacio_id` (`variacio_id`);

--
-- A tábla indexei `kategoria`
--
ALTER TABLE `kategoria`
  ADD PRIMARY KEY (`id`),
  ADD KEY `szulo_id` (`szulo_id`),
  ADD KEY `oldal_id` (`oldal_id`);

--
-- A tábla indexei `kosar`
--
ALTER TABLE `kosar`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vasarlo_id` (`vasarlo_id`),
  ADD KEY `fizetes_id` (`fizetes_id`),
  ADD KEY `szallitas_id` (`szallitas_id`),
  ADD KEY `szallitasi_cim_id` (`szallitasi_cim_id`),
  ADD KEY `szamlazasi_cim_id` (`szamlazasi_cim_id`),
  ADD KEY `kupon_id` (`kupon_id`),
  ADD KEY `email_logo_id` (`email_logo_id`);

--
-- A tábla indexei `kosar_kedveles`
--
ALTER TABLE `kosar_kedveles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kosar_id` (`kosar_id`),
  ADD KEY `termek_id` (`termek_id`),
  ADD KEY `variacio_id` (`variacio_id`);

--
-- A tábla indexei `kosar_tetel`
--
ALTER TABLE `kosar_tetel`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kosar_id` (`kosar_id`),
  ADD KEY `kosar_tetel_ibfk_2` (`termek_id`),
  ADD KEY `kosar_tetel_ibfk_3` (`variacio_id`);

--
-- A tábla indexei `kupon`
--
ALTER TABLE `kupon`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kod` (`kod`);

--
-- A tábla indexei `munkamenet`
--
ALTER TABLE `munkamenet`
  ADD PRIMARY KEY (`id`),
  ADD KEY `felhasznalo_id` (`felhasznalo_id`);

--
-- A tábla indexei `oldal`
--
ALTER TABLE `oldal`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kep_id` (`kep_id`);

--
-- A tábla indexei `orszag`
--
ALTER TABLE `orszag`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `promocio`
--
ALTER TABLE `promocio`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kategoria_id` (`kategoria_id`);

--
-- A tábla indexei `slider`
--
ALTER TABLE `slider`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kep_id` (`kep_id`);

--
-- A tábla indexei `statikus_oldal`
--
ALTER TABLE `statikus_oldal`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oldal_id` (`oldal_id`);

--
-- A tábla indexei `statikus_szoveg`
--
ALTER TABLE `statikus_szoveg`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nev` (`nev`);

--
-- A tábla indexei `szallitas`
--
ALTER TABLE `szallitas`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `szallitas_fizetes`
--
ALTER TABLE `szallitas_fizetes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `szallitas_id` (`szallitas_id`),
  ADD KEY `fizetes_id` (`fizetes_id`);

--
-- A tábla indexei `szamla`
--
ALTER TABLE `szamla`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kosar_id` (`kosar_id`);

--
-- A tábla indexei `tartalom`
--
ALTER TABLE `tartalom`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `termek`
--
ALTER TABLE `termek`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kategoria_id` (`kategoria_id`),
  ADD KEY `oldal_id` (`oldal_id`),
  ADD KEY `foto_id` (`foto_id`),
  ADD KEY `egyseg_id` (`egyseg_id`);

--
-- A tábla indexei `termekajanlo`
--
ALTER TABLE `termekajanlo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `masik_termek_id` (`masik_termek_id`);

--
-- A tábla indexei `termek_tulajdonsag`
--
ALTER TABLE `termek_tulajdonsag`
  ADD PRIMARY KEY (`id`),
  ADD KEY `termek_id` (`termek_id`),
  ADD KEY `ertek_file` (`ertek_file`),
  ADD KEY `ertek_id` (`ertek_id`),
  ADD KEY `tulajdonsag_id` (`tulajdonsag_id`);

--
-- A tábla indexei `termek_tulajdonsag_ertek`
--
ALTER TABLE `termek_tulajdonsag_ertek`
  ADD PRIMARY KEY (`id`),
  ADD KEY `termek_tulajdonsag_id` (`termek_tulajdonsag_id`),
  ADD KEY `tulajdonsag_opcio_id` (`tulajdonsag_opcio_id`);

--
-- A tábla indexei `tulajdonsag`
--
ALTER TABLE `tulajdonsag`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `tulajdonsag_opcio`
--
ALTER TABLE `tulajdonsag_opcio`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tulajdonsag_id` (`tulajdonsag_id`);

--
-- A tábla indexei `variacio`
--
ALTER TABLE `variacio`
  ADD PRIMARY KEY (`id`),
  ADD KEY `termek_id` (`termek_id`),
  ADD KEY `variacio_ibfk_2` (`opcio_1`),
  ADD KEY `variacio_ibfk_3` (`opcio_2`),
  ADD KEY `opcio_3` (`opcio_3`),
  ADD KEY `variacio_ibfk_5` (`opcio_4`),
  ADD KEY `opcio_5` (`opcio_5`),
  ADD KEY `foto_id` (`foto_id`);

--
-- A tábla indexei `vasarlo`
--
ALTER TABLE `vasarlo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `szallitasi_cim_id` (`szallitasi_cim_id`),
  ADD KEY `szamlazasi_cim_id` (`szamlazasi_cim_id`);

--
-- A kiírt táblák AUTO_INCREMENT értéke
--

--
-- AUTO_INCREMENT a táblához `beallitasok`
--
ALTER TABLE `beallitasok`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT a táblához `bejelentkezes_2fa`
--
ALTER TABLE `bejelentkezes_2fa`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT a táblához `cim`
--
ALTER TABLE `cim`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT a táblához `egyseg`
--
ALTER TABLE `egyseg`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT a táblához `email_sablon`
--
ALTER TABLE `email_sablon`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT a táblához `fajl`
--
ALTER TABLE `fajl`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT a táblához `felhasznalo`
--
ALTER TABLE `felhasznalo`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT a táblához `felhasznalo_naplo`
--
ALTER TABLE `felhasznalo_naplo`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT a táblához `fizetes`
--
ALTER TABLE `fizetes`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT a táblához `hir`
--
ALTER TABLE `hir`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT a táblához `hir_kategoria`
--
ALTER TABLE `hir_kategoria`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT a táblához `kapcsolat`
--
ALTER TABLE `kapcsolat`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT a táblához `kategoria`
--
ALTER TABLE `kategoria`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT a táblához `kosar`
--
ALTER TABLE `kosar`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT a táblához `kosar_kedveles`
--
ALTER TABLE `kosar_kedveles`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT a táblához `kosar_tetel`
--
ALTER TABLE `kosar_tetel`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT a táblához `kupon`
--
ALTER TABLE `kupon`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT a táblához `munkamenet`
--
ALTER TABLE `munkamenet`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT a táblához `oldal`
--
ALTER TABLE `oldal`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT a táblához `orszag`
--
ALTER TABLE `orszag`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT a táblához `promocio`
--
ALTER TABLE `promocio`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT a táblához `slider`
--
ALTER TABLE `slider`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT a táblához `statikus_oldal`
--
ALTER TABLE `statikus_oldal`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT a táblához `statikus_szoveg`
--
ALTER TABLE `statikus_szoveg`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT a táblához `szallitas`
--
ALTER TABLE `szallitas`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT a táblához `szallitas_fizetes`
--
ALTER TABLE `szallitas_fizetes`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT a táblához `szamla`
--
ALTER TABLE `szamla`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT a táblához `tartalom`
--
ALTER TABLE `tartalom`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT a táblához `termek`
--
ALTER TABLE `termek`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT a táblához `termekajanlo`
--
ALTER TABLE `termekajanlo`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT a táblához `termek_tulajdonsag`
--
ALTER TABLE `termek_tulajdonsag`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT a táblához `termek_tulajdonsag_ertek`
--
ALTER TABLE `termek_tulajdonsag_ertek`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT a táblához `tulajdonsag`
--
ALTER TABLE `tulajdonsag`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT a táblához `tulajdonsag_opcio`
--
ALTER TABLE `tulajdonsag_opcio`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT a táblához `variacio`
--
ALTER TABLE `variacio`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT a táblához `vasarlo`
--
ALTER TABLE `vasarlo`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- Megkötések a kiírt táblákhoz
--

--
-- Megkötések a táblához `beallitasok`
--
ALTER TABLE `beallitasok`
  ADD CONSTRAINT `beallitasok_ibfk_1` FOREIGN KEY (`ceg_cim_id`) REFERENCES `cim` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `beallitasok_ibfk_2` FOREIGN KEY (`email_logo_id`) REFERENCES `fajl` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Megkötések a táblához `bejelentkezes_2fa`
--
ALTER TABLE `bejelentkezes_2fa`
  ADD CONSTRAINT `bejelentkezes_2fa_ibfk_1` FOREIGN KEY (`felhasznalo_id`) REFERENCES `felhasznalo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Megkötések a táblához `cim`
--
ALTER TABLE `cim`
  ADD CONSTRAINT `cim_ibfk_1` FOREIGN KEY (`orszag_id`) REFERENCES `orszag` (`id`);

--
-- Megkötések a táblához `fajl`
--
ALTER TABLE `fajl`
  ADD CONSTRAINT `fajl_ibfk_1` FOREIGN KEY (`felhasznalo_id`) REFERENCES `felhasznalo` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Megkötések a táblához `felhasznalo`
--
ALTER TABLE `felhasznalo`
  ADD CONSTRAINT `felhasznalo_ibfk_1` FOREIGN KEY (`profilkep_id`) REFERENCES `fajl` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Megkötések a táblához `felhasznalo_naplo`
--
ALTER TABLE `felhasznalo_naplo`
  ADD CONSTRAINT `felhasznalo_naplo_ibfk_1` FOREIGN KEY (`felhasznalo_id`) REFERENCES `felhasznalo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Megkötések a táblához `hir`
--
ALTER TABLE `hir`
  ADD CONSTRAINT `hir_ibfk_1` FOREIGN KEY (`kategoria_id`) REFERENCES `hir_kategoria` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Megkötések a táblához `hir_kategoria`
--
ALTER TABLE `hir_kategoria`
  ADD CONSTRAINT `hir_kategoria_ibfk_1` FOREIGN KEY (`meta_kep_id`) REFERENCES `fajl` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Megkötések a táblához `kapcsolat`
--
ALTER TABLE `kapcsolat`
  ADD CONSTRAINT `kapcsolat_ibfk_1` FOREIGN KEY (`termek_id`) REFERENCES `termek` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `kapcsolat_ibfk_2` FOREIGN KEY (`variacio_id`) REFERENCES `variacio` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Megkötések a táblához `kategoria`
--
ALTER TABLE `kategoria`
  ADD CONSTRAINT `kategoria_ibfk_1` FOREIGN KEY (`szulo_id`) REFERENCES `kategoria` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `kategoria_ibfk_2` FOREIGN KEY (`oldal_id`) REFERENCES `oldal` (`id`);

--
-- Megkötések a táblához `kosar`
--
ALTER TABLE `kosar`
  ADD CONSTRAINT `kosar_ibfk_1` FOREIGN KEY (`vasarlo_id`) REFERENCES `vasarlo` (`id`),
  ADD CONSTRAINT `kosar_ibfk_2` FOREIGN KEY (`fizetes_id`) REFERENCES `fizetes` (`id`),
  ADD CONSTRAINT `kosar_ibfk_3` FOREIGN KEY (`szallitas_id`) REFERENCES `szallitas` (`id`),
  ADD CONSTRAINT `kosar_ibfk_4` FOREIGN KEY (`szallitasi_cim_id`) REFERENCES `cim` (`id`),
  ADD CONSTRAINT `kosar_ibfk_5` FOREIGN KEY (`szamlazasi_cim_id`) REFERENCES `cim` (`id`),
  ADD CONSTRAINT `kosar_ibfk_6` FOREIGN KEY (`kupon_id`) REFERENCES `kupon` (`id`),
  ADD CONSTRAINT `kosar_ibfk_7` FOREIGN KEY (`email_logo_id`) REFERENCES `fajl` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Megkötések a táblához `kosar_kedveles`
--
ALTER TABLE `kosar_kedveles`
  ADD CONSTRAINT `kosar_kedveles_ibfk_1` FOREIGN KEY (`kosar_id`) REFERENCES `kosar` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `kosar_kedveles_ibfk_2` FOREIGN KEY (`termek_id`) REFERENCES `termek` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `kosar_kedveles_ibfk_3` FOREIGN KEY (`variacio_id`) REFERENCES `variacio` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Megkötések a táblához `kosar_tetel`
--
ALTER TABLE `kosar_tetel`
  ADD CONSTRAINT `kosar_tetel_ibfk_1` FOREIGN KEY (`kosar_id`) REFERENCES `kosar` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `kosar_tetel_ibfk_2` FOREIGN KEY (`termek_id`) REFERENCES `termek` (`id`),
  ADD CONSTRAINT `kosar_tetel_ibfk_3` FOREIGN KEY (`variacio_id`) REFERENCES `variacio` (`id`);

--
-- Megkötések a táblához `munkamenet`
--
ALTER TABLE `munkamenet`
  ADD CONSTRAINT `munkamenet_ibfk_1` FOREIGN KEY (`felhasznalo_id`) REFERENCES `felhasznalo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Megkötések a táblához `oldal`
--
ALTER TABLE `oldal`
  ADD CONSTRAINT `oldal_ibfk_1` FOREIGN KEY (`kep_id`) REFERENCES `fajl` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Megkötések a táblához `promocio`
--
ALTER TABLE `promocio`
  ADD CONSTRAINT `promocio_ibfk_1` FOREIGN KEY (`kategoria_id`) REFERENCES `kategoria` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Megkötések a táblához `slider`
--
ALTER TABLE `slider`
  ADD CONSTRAINT `slider_ibfk_1` FOREIGN KEY (`kep_id`) REFERENCES `fajl` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Megkötések a táblához `statikus_oldal`
--
ALTER TABLE `statikus_oldal`
  ADD CONSTRAINT `statikus_oldal_ibfk_1` FOREIGN KEY (`oldal_id`) REFERENCES `oldal` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Megkötések a táblához `szallitas_fizetes`
--
ALTER TABLE `szallitas_fizetes`
  ADD CONSTRAINT `szallitas_fizetes_ibfk_1` FOREIGN KEY (`szallitas_id`) REFERENCES `szallitas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `szallitas_fizetes_ibfk_2` FOREIGN KEY (`fizetes_id`) REFERENCES `fizetes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Megkötések a táblához `szamla`
--
ALTER TABLE `szamla`
  ADD CONSTRAINT `szamla_ibfk_1` FOREIGN KEY (`kosar_id`) REFERENCES `kosar` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Megkötések a táblához `termek`
--
ALTER TABLE `termek`
  ADD CONSTRAINT `termek_ibfk_1` FOREIGN KEY (`kategoria_id`) REFERENCES `kategoria` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `termek_ibfk_2` FOREIGN KEY (`oldal_id`) REFERENCES `oldal` (`id`),
  ADD CONSTRAINT `termek_ibfk_3` FOREIGN KEY (`foto_id`) REFERENCES `fajl` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `termek_ibfk_4` FOREIGN KEY (`egyseg_id`) REFERENCES `egyseg` (`id`);

--
-- Megkötések a táblához `termekajanlo`
--
ALTER TABLE `termekajanlo`
  ADD CONSTRAINT `termekajanlo_ibfk_1` FOREIGN KEY (`masik_termek_id`) REFERENCES `termek` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Megkötések a táblához `termek_tulajdonsag`
--
ALTER TABLE `termek_tulajdonsag`
  ADD CONSTRAINT `termek_tulajdonsag_ibfk_1` FOREIGN KEY (`termek_id`) REFERENCES `termek` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `termek_tulajdonsag_ibfk_2` FOREIGN KEY (`ertek_file`) REFERENCES `fajl` (`id`),
  ADD CONSTRAINT `termek_tulajdonsag_ibfk_3` FOREIGN KEY (`ertek_id`) REFERENCES `tulajdonsag_opcio` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `termek_tulajdonsag_ibfk_4` FOREIGN KEY (`tulajdonsag_id`) REFERENCES `tulajdonsag` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Megkötések a táblához `termek_tulajdonsag_ertek`
--
ALTER TABLE `termek_tulajdonsag_ertek`
  ADD CONSTRAINT `termek_tulajdonsag_ertek_ibfk_1` FOREIGN KEY (`termek_tulajdonsag_id`) REFERENCES `termek_tulajdonsag` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `termek_tulajdonsag_ertek_ibfk_2` FOREIGN KEY (`tulajdonsag_opcio_id`) REFERENCES `tulajdonsag_opcio` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Megkötések a táblához `tulajdonsag_opcio`
--
ALTER TABLE `tulajdonsag_opcio`
  ADD CONSTRAINT `tulajdonsag_opcio_ibfk_1` FOREIGN KEY (`tulajdonsag_id`) REFERENCES `tulajdonsag` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Megkötések a táblához `variacio`
--
ALTER TABLE `variacio`
  ADD CONSTRAINT `variacio_ibfk_1` FOREIGN KEY (`termek_id`) REFERENCES `termek` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `variacio_ibfk_2` FOREIGN KEY (`opcio_1`) REFERENCES `tulajdonsag_opcio` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `variacio_ibfk_3` FOREIGN KEY (`opcio_2`) REFERENCES `tulajdonsag_opcio` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `variacio_ibfk_4` FOREIGN KEY (`opcio_3`) REFERENCES `tulajdonsag_opcio` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `variacio_ibfk_5` FOREIGN KEY (`opcio_4`) REFERENCES `tulajdonsag_opcio` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `variacio_ibfk_6` FOREIGN KEY (`opcio_5`) REFERENCES `tulajdonsag_opcio` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `variacio_ibfk_7` FOREIGN KEY (`foto_id`) REFERENCES `fajl` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Megkötések a táblához `vasarlo`
--
ALTER TABLE `vasarlo`
  ADD CONSTRAINT `vasarlo_ibfk_1` FOREIGN KEY (`szallitasi_cim_id`) REFERENCES `cim` (`id`),
  ADD CONSTRAINT `vasarlo_ibfk_2` FOREIGN KEY (`szamlazasi_cim_id`) REFERENCES `cim` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
