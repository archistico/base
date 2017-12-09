
CREATE TABLE `utente` (
  `utenteid` int(11) NOT NULL,
  `denominazione` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `indirizzo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `cf` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `piva` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `telefono` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `account` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `tipologia` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

ALTER TABLE `utente`
  ADD PRIMARY KEY (`utenteid`);

ALTER TABLE `utente`
MODIFY `utenteid` int(11) NOT NULL AUTO_INCREMENT;