CREATE TABLE `artists` (
  `id` INTEGER PRIMARY KEY AUTOINCREMENT,
  `name` varchar(72) NOT NULL
);

INSERT INTO "artists" VALUES(1,'Lana del Rey');
INSERT INTO "artists" VALUES(2,'Radiohead');

CREATE TABLE `albums` (
  `id` INTEGER PRIMARY KEY AUTOINCREMENT,
  `artists_id` int(10) NOT NULL,
  `name` varchar(72) NOT NULL
);

CREATE INDEX albums_artists_id_idx ON albums (`artists_id`);

INSERT INTO "albums" VALUES(1,1,'Born to Die');
INSERT INTO "albums" VALUES(2,1,'Born to Die - The Paradise Edition');

CREATE TABLE `songs` (
  `id` INTEGER PRIMARY KEY AUTOINCREMENT,
  `albums_id` int(10) NOT NULL,
  `name` varchar(72) NOT NULL
);

CREATE INDEX songs_albums_id_idx ON songs (`albums_id`);

INSERT INTO "songs" VALUES(1,1,'Born to Die');
INSERT INTO "songs" VALUES(2,1,'Off to Races');
INSERT INTO "songs" VALUES(3,1,'Blue Jeans');
INSERT INTO "songs" VALUES(4,1,'Video Games');
INSERT INTO "songs" VALUES(5,1,'Diet Mountain Dew');
INSERT INTO "songs" VALUES(6,1,'National Anthem');
INSERT INTO "songs" VALUES(7,1,'Dark Paradise');
