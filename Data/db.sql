-- phpMyAdmin SQL Dump
-- version 4.6.6deb1+deb.cihar.com~xenial.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Czas generowania: 24 Maj 2017, 15:12
-- Wersja serwera: 5.7.17-0ubuntu0.16.04.1
-- Wersja PHP: 7.0.15-0ubuntu0.16.04.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `twitter`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `Comment`
--

CREATE TABLE `Comment` (
  `id` int(11) NOT NULL,
  `tweetId` int(11) NOT NULL,
  `text` varchar(60) DEFAULT NULL,
  `creationDate` datetime NOT NULL,
  `userId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Zrzut danych tabeli `Comment`
--

INSERT INTO `Comment` (`id`, `tweetId`, `text`, `creationDate`, `userId`) VALUES
(43, 15, 'A ja zupeÅ‚nie nie!', '2017-05-24 15:10:26', 38);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `Message`
--

CREATE TABLE `Message` (
  `id` int(11) NOT NULL,
  `senderId` int(11) NOT NULL,
  `receiverId` int(11) NOT NULL,
  `topic` varchar(90) NOT NULL,
  `text` varchar(255) NOT NULL,
  `creationDate` datetime NOT NULL,
  `readCheck` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Zrzut danych tabeli `Message`
--

INSERT INTO `Message` (`id`, `senderId`, `receiverId`, `topic`, `text`, `creationDate`, `readCheck`) VALUES
(7, 38, 38, 'topic 2', 'Maecenas ligula nisi, fermentum a facilisis at, volutpat ac velit. Proin massa est, porta at libero sit amet, dignissim cursus massa. Ut auctor augue eget elit eleifend pulvinar. ', '2017-05-23 00:00:00', 0),
(9, 40, 38, 'Drogi Matt', 'Jest tu piÄ™knie ciepÅ‚o i sucho , opalam sie codziennie.', '2017-05-24 00:05:27', 0),
(11, 40, 40, 'test', 'blablabla', '2017-05-24 01:34:56', 0);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `Tweet`
--

CREATE TABLE `Tweet` (
  `id` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `text` varchar(140) DEFAULT NULL,
  `creationDate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Zrzut danych tabeli `Tweet`
--

INSERT INTO `Tweet` (`id`, `userId`, `text`, `creationDate`) VALUES
(11, 38, 'Mysle o polskich znakach', '2017-05-20 12:12:50'),
(15, 40, 'Jestem zadowolona', '2017-05-21 14:11:02'),
(23, 38, 'Jaki jest piÄ™kny dzien.', '2017-05-22 11:33:23');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `User`
--

CREATE TABLE `User` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `hashPassword` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Zrzut danych tabeli `User`
--

INSERT INTO `User` (`id`, `username`, `email`, `hashPassword`) VALUES
(38, 'Mateusz', 'matt@10g.pl', '$2y$10$4rEvUeVxwKGdrqs1AI//VOgOPgEtbYA5zDsS1G8QrdUn6ouXjAfaq'),
(39, 'Tomasz', 'tom@tlen.pl', '$2y$10$DLKZevIZsVHhJFkuTNYLreoAScHZZpaRP3GyqDkHqK0p9sXBa3vq2'),
(40, 'Ela', 'ela@o2.pl', '$2y$10$QbB.rwRGrosxWkknewlSQei/UOJm/0bX7KEzW/QcNRsrUCNpZp/1O');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indexes for table `Comment`
--
ALTER TABLE `Comment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Comment_ibfk_1` (`tweetId`),
  ADD KEY `Comment_ibfk_2` (`userId`);

--
-- Indexes for table `Message`
--
ALTER TABLE `Message`
  ADD PRIMARY KEY (`id`),
  ADD KEY `senderId` (`senderId`),
  ADD KEY `receiverId` (`receiverId`);

--
-- Indexes for table `Tweet`
--
ALTER TABLE `Tweet`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Tweet_ibfk_1` (`userId`);

--
-- Indexes for table `User`
--
ALTER TABLE `User`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT dla tabeli `Comment`
--
ALTER TABLE `Comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;
--
-- AUTO_INCREMENT dla tabeli `Message`
--
ALTER TABLE `Message`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT dla tabeli `Tweet`
--
ALTER TABLE `Tweet`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;
--
-- AUTO_INCREMENT dla tabeli `User`
--
ALTER TABLE `User`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;
--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `Comment`
--
ALTER TABLE `Comment`
  ADD CONSTRAINT `Comment_ibfk_1` FOREIGN KEY (`tweetId`) REFERENCES `Tweet` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Comment_ibfk_2` FOREIGN KEY (`userId`) REFERENCES `User` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ograniczenia dla tabeli `Message`
--
ALTER TABLE `Message`
  ADD CONSTRAINT `Message_ibfk_1` FOREIGN KEY (`senderId`) REFERENCES `User` (`id`),
  ADD CONSTRAINT `Message_ibfk_2` FOREIGN KEY (`receiverId`) REFERENCES `User` (`id`);

--
-- Ograniczenia dla tabeli `Tweet`
--
ALTER TABLE `Tweet`
  ADD CONSTRAINT `Tweet_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `User` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
