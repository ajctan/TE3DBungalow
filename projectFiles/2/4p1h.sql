DROP SCHEMA IF EXISTS 4P1H;
CREATE SCHEMA 4P1H;
USE 4P1H;

CREATE TABLE player_table 
(
	username varchar(69) NOT NULL,
	email varchar(69) NOT NULL,
	pword varchar(69) NOT NULL,
	pmade int not null,
	psolved int not null,
	csolved int not null,
    playericon longblob,
	  
	PRIMARY KEY (username)
);

CREATE TABLE puzzle_table 
(
    puzzleID int not null,
    puzzlekey varchar(69) not null,
    puzzleowner varchar(69) not null, 
    picture1 longblob not null,
    picture2 longblob not null,
    picture3 longblob not null,
    picture4 longblob not null,
    
    PRIMARY KEY (puzzleID)
);

CREATE TABLE challenge_table 
(
	challenger varchar(69) not null,
    challengedperson varchar(69) not null,
    puzzleID int not null, -- yes
    message varchar(200),
    
    PRIMARY KEY (challenger)
);