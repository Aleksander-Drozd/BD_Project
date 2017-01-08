-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Czas generowania: 08 Sty 2017, 22:22
-- Wersja serwera: 10.1.16-MariaDB
-- Wersja PHP: 5.6.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `bike_rental`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `first_name` varchar(50) COLLATE utf8_polish_ci NOT NULL,
  `last_name` varchar(50) COLLATE utf8_polish_ci NOT NULL,
  `email` varchar(50) COLLATE utf8_polish_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_polish_ci NOT NULL,
  `phone_number` varchar(11) COLLATE utf8_polish_ci NOT NULL,
  `wallet` decimal(8,2) NOT NULL DEFAULT '0.00',
  `rented_bikes` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `customers`
--

INSERT INTO `customers` (`id`, `first_name`, `last_name`, `email`, `password`, `phone_number`, `wallet`, `rented_bikes`) VALUES
(1, 'Piotr', 'Śmiechowski', 'piotr.smiech@onet.pl', '$2y$10$bYe1bBOjHEX2h.DvOTfTnOCO9.Cl1HfX5AQruBBjja9iKJ092bDaq', '662876231', '17.00', 1),
(3, 'Jarosław', 'Pośpiechowski', 'jarek_pop@onet.pl', '$2y$10$EFi4HnCLjuYcIg9SnpxQPe4Lr5M5Iod6EwH75/rgwyDZGij1HT9Jq', '661510923', '0.00', 0),
(4, 'Mikołaj', 'Nowacki', 'nowe_mikolajki@onet.pl', '$2y$10$2SwFVbguCLgd0sOwc.dGu.4K.UkZj09fVPw5XlN49ANeYRc42VAEa', '807283470', '2.00', 1),
(5, 'Marek', 'Jałowiec', 'wyjalowiony@onet.pl', '$2y$10$VAL8PmpYvIxskwqTKNYYRufsiRfuXniB5lewoy8GibCzcvj8L9JUS', '661510923', '0.00', 0),
(6, 'Ludwik', 'Wojciechowski', 'test@test.com', '$2y$10$Bq.yVQJxoTcWqWoUZ934NuYojVHKOqOKXq7Vzt/dyvzLJ84NQxqOu', '111222333', '-665.00', 0);

--
-- Indeksy dla zrzutów tabel
--

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT dla tabeli `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
