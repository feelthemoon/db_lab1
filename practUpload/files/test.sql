SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

CREATE DATABASE IF NOT EXISTS test;

CREATE TABLE `files` (
  `id_file` int(11) NOT NULL,
  `id_my` int(11) NOT NULL,
  `description` text NOT NULL,
  `name_origin` text NOT NULL,
  `path` text NOT NULL,
  `date_upload` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=cp1251;


INSERT INTO files (`id_file`, `id_my`, `description`, `name_origin`, `path`, `date_upload`) VALUES
(48, 25, 'Закачка из менеджера', '3-Март.jpg', 'files/3-Март.jpg', '16-02-2022  02:00:11'),
(49, 23, 'Закачка из менеджера', '1-Январь.jpg', 'files/1-Январь.jpg', '17-02-2022  08:20:24'),
(50, 23, 'Закачка из менеджера', '2-Февраль.jpg', 'files/2-Февраль.jpg', '17-02-2022  08:20:24'),
(51, 23, 'Закачка из менеджера', '3-Март.jpg', 'files/3-Март.jpg', '17-02-2022  08:20:24'),
(52, 23, 'Закачка из менеджера', '4-Апрель.jpg', 'files/4-Апрель.jpg', '17-02-2022  08:20:37'),
(53, 23, 'Закачка из менеджера', '5-Май.jpg', 'files/5-Май.jpg', '17-02-2022  08:20:37'),
(54, 23, 'Закачка из менеджера', '6-Июнь.jpg', 'files/6-Июнь.jpg', '17-02-2022  08:20:37'),
(55, 23, 'Закачка из менеджера', '7-Июль.jpg', 'files/7-Июль.jpg', '17-02-2022  08:20:53'),
(56, 23, 'Закачка из менеджера', '8-Август.jpg', 'files/8-Август.jpg', '17-02-2022  08:20:53'),
(57, 23, 'Закачка из менеджера', '9-Сентябрь.jpg', 'files/9-Сентябрь.jpg', '17-02-2022  08:20:53'),
(58, 23, 'Закачка из менеджера', '10-Октябрь.jpg', 'files/10-Октябрь.jpg', '17-02-2022  08:21:11'),
(59, 23, 'Закачка из менеджера', '11-Ноябрь.jpg', 'files/11-Ноябрь.jpg', '17-02-2022  08:21:11'),
(60, 23, 'Закачка из менеджера', '12-Декабрь.jpg', 'files/12-Декабрь.jpg', '17-02-2022  08:21:11'),
(61, 23, 'Закачка из менеджера', 'lecture_1.pdf', 'files/lecture_1.pdf', '17-02-2022  08:21:33'),
(62, 23, 'Закачка из менеджера', 'lecture_2.pdf', 'files/lecture_2.pdf', '17-02-2022  08:21:33'),
(63, 23, 'Закачка из менеджера', 'test.sql', 'files/test.sql', '17-02-2022  08:21:33');

CREATE TABLE `myarttable` (
  `id` int(11) NOT NULL,
  `text` text NOT NULL,
  `description` text NOT NULL,
  `keywords` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=cp1251;

INSERT INTO `myarttable` (`id`, `text`, `description`, `keywords`) VALUES
(20, 'Февраль', '128', 'Сидоров В.Н.'),
(21, 'Март', '520', 'Васильев Н.К.'),
(23, 'Май', '629', 'Смирнов В.Ю.'),
(24, 'Июнь', '371', 'Петров К.Д.'),
(25, 'Июль', '542', 'Субботин А.Н.'),
(26, 'Август', '389', 'Данилин В.Д.');

ALTER TABLE `files`
  ADD PRIMARY KEY (`id_file`),
  ADD KEY `id_my` (`id_my`);

ALTER TABLE `myarttable`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `files`
  MODIFY `id_file` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

ALTER TABLE `myarttable`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

ALTER TABLE `files`
  ADD CONSTRAINT `files_ibfk_1` FOREIGN KEY (`id_my`) REFERENCES `myarttable` (`id`);
COMMIT;