-- phpMyAdmin SQL Dump
-- version 5.1.2
-- https://www.phpmyadmin.net/
--
-- ホスト: localhost:8889
-- 生成日時: 2022-11-30 08:05:11
-- サーバのバージョン： 5.7.24
-- PHP のバージョン: 8.0.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- データベース: `pokemondb`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `move`
--

CREATE TABLE `move` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `type` int(11) NOT NULL,
  `power` int(11) NOT NULL,
  `class` text NOT NULL,
  `priority` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `move`
--

INSERT INTO `move` (`id`, `name`, `type`, `power`, `class`, `priority`) VALUES
(1, 'かえんほうしゃ', 2, 90, 'sp', 0),
(2, 'フレアドライブ', 2, 120, 'phy', 0),
(3, 'りゅうのはどう', 15, 85, 'sp', 0),
(4, 'しんそく', 1, 80, 'phy', 2),
(5, 'れいとうビーム', 6, 90, 'sp', 0),
(6, 'じしん', 9, 100, 'phy', 0),
(7, 'アイアンヘッド', 17, 80, 'phy', 0),
(8, 'ドラゴンクロー', 15, 80, 'phy', 0),
(9, 'シャドーボール', 14, 80, 'sp', 0),
(10, 'フリーズドライ', 6, 70, 'sp', 0),
(11, 'かみくだく', 16, 80, 'phy', 0),
(12, 'アクアジェット', 3, 40, 'phy', 1),
(14, 'でんこうせっか', 1, 40, 'phy', 1),
(15, '10まんボルト', 4, 90, 'sp', 0),
(16, 'なみのり', 3, 90, 'sp', 0),
(17, 'タネばくだん', 5, 80, 'phy', 0),
(18, 'マッハパンチ', 7, 40, 'phy', 1),
(19, 'つばめがえし', 10, 60, 'phy', 0),
(20, 'ムーンフォース', 18, 95, 'sp', 0),
(21, 'ラスターカノン', 17, 80, 'sp', 0),
(22, 'サイコキネシス', 11, 90, 'sp', 0),
(23, 'ドラゴンアロー', 15, 100, 'phy', 0),
(24, 'こおりのつぶて', 6, 40, 'phy', 1),
(25, 'いわなだれ', 13, 75, 'phy', 0),
(26, 'イナズマドライブ', 4, 100, 'sp', 0),
(27, 'メガホーン', 12, 120, 'phy', 0),
(28, 'どくづき', 8, 80, 'phy', 0),
(29, 'ばかぢから', 7, 120, 'phy', 0);

-- --------------------------------------------------------

--
-- テーブルの構造 `pokemon`
--

CREATE TABLE `pokemon` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `type1` int(11) NOT NULL,
  `type2` int(11) DEFAULT NULL,
  `hp` int(11) NOT NULL,
  `atk` int(11) NOT NULL,
  `def` int(11) NOT NULL,
  `sp_atk` int(11) NOT NULL,
  `sp_def` int(11) NOT NULL,
  `speed` int(11) NOT NULL,
  `tech1` int(11) DEFAULT NULL,
  `tech2` int(11) DEFAULT NULL,
  `tech3` int(11) DEFAULT NULL,
  `tech4` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `pokemon`
--

INSERT INTO `pokemon` (`id`, `name`, `type1`, `type2`, `hp`, `atk`, `def`, `sp_atk`, `sp_def`, `speed`, `tech1`, `tech2`, `tech3`, `tech4`) VALUES
(1, 'ウインディ', 2, NULL, 90, 110, 80, 100, 80, 95, 1, 2, 3, 4),
(2, 'オニゴーリ', 6, NULL, 80, 80, 80, 80, 80, 80, 5, 10, 11, 24),
(3, 'オノノクス', 15, NULL, 76, 147, 90, 60, 70, 97, 8, 6, 7, 3),
(4, 'ドラパルト', 15, 14, 88, 120, 75, 100, 75, 142, 23, 9, 14, 16),
(5, 'エンペルト', 3, 17, 84, 86, 88, 111, 101, 60, 16, 21, 19, 5),
(6, 'キノガッサ', 5, 7, 60, 130, 80, 60, 60, 70, 17, 18, 19, 25),
(7, 'サーナイト', 11, 18, 68, 65, 65, 125, 115, 80, 22, 20, 9, 15),
(8, 'ペンドラー', 12, 8, 60, 100, 89, 55, 69, 112, 27, 28, 29, 6);

-- --------------------------------------------------------

--
-- テーブルの構造 `type`
--

CREATE TABLE `type` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `super_effective` text,
  `not_effective` text,
  `not_affect` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `type`
--

INSERT INTO `type` (`id`, `name`, `super_effective`, `not_effective`, `not_affect`) VALUES
(1, 'ノーマル', '', '13,17', '14'),
(2, 'ほのお', '5,6,12,17', '2,3,13,15', ''),
(3, 'みず', '2,9,13', '3,5,15', ''),
(4, 'でんき', '3,10', '4,5,15', '9'),
(5, 'くさ', '3,9,13', '2,5,8,10,12,15,17', ''),
(6, 'こおり', '5,9,10,15', '2,3,6,17', ''),
(7, 'かくとう', '1,6,13,16,17', '8,10,11,12,18', '14'),
(8, 'どく', '5,18', '7,8,13,14', '17'),
(9, 'じめん', '2,4,8,13,17', '5,12', '10'),
(10, 'ひこう', '5,7,12', '4,13,17', ''),
(11, 'エスパー', '7,8', '11,17', '16'),
(12, 'むし', '5,11,16', '2,7,8,10,14,17,18', ''),
(13, 'いわ', '2,6,10,12', '7,9,17', ''),
(14, 'ゴースト', '11,14', '16', '1'),
(15, 'ドラゴン', '15', '17', '18'),
(16, 'あく', '11,14', '7,16,18', ''),
(17, 'はがね', '6,13,18', '2,4,7,17', ''),
(18, 'フェアリー', '7,15,16', '2,8,17', '');

--
-- ダンプしたテーブルのインデックス
--

--
-- テーブルのインデックス `move`
--
ALTER TABLE `move`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `pokemon`
--
ALTER TABLE `pokemon`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `type`
--
ALTER TABLE `type`
  ADD PRIMARY KEY (`id`);

--
-- ダンプしたテーブルの AUTO_INCREMENT
--

--
-- テーブルの AUTO_INCREMENT `move`
--
ALTER TABLE `move`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- テーブルの AUTO_INCREMENT `pokemon`
--
ALTER TABLE `pokemon`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- テーブルの AUTO_INCREMENT `type`
--
ALTER TABLE `type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
