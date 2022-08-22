CREATE TABLE contafelrunde.tr_user (
	tr_user_id int(8) auto_increment NOT NULL,
	tr_user_name varchar(255) NULL,
	tr_user_mail varchar(255) NULL,
	tr_user_password varchar(255) NULL,
	tr_user_secret varchar(255) NULL,
	tr_user_active int(1) DEFAULT 1 NULL,
	tr_user_admin int(1) DEFAULT 0 NULL,
	tr_user_modify_id int(8) NULL,
	tr_user_modify_ts bigint NULL,
	CONSTRAINT tr_user_PK PRIMARY KEY (tr_user_id)
)
ENGINE=InnoDB
DEFAULT CHARSET=latin1
COLLATE=latin1_swedish_ci;



CREATE TABLE contafelrunde.tr_convention (
	tr_convention_id int(8) auto_increment NOT NULL,
	tr_convention_name varchar(255) NULL,
	tr_convention_icon varchar(255) NULL,
	tr_convention_text varchar(255) NULL,
	tr_convention_modify_id int(8) NULL,
	tr_convention_modify_ts bigint NULL,
	CONSTRAINT tr_convention_PK PRIMARY KEY (tr_convention_id),
	CONSTRAINT tr_convention_FK FOREIGN KEY (tr_convention_modify_id) REFERENCES contafelrunde.tr_user(tr_user_id) ON DELETE RESTRICT ON UPDATE RESTRICT
)
ENGINE=InnoDB
DEFAULT CHARSET=latin1
COLLATE=latin1_swedish_ci;



CREATE TABLE contafelrunde.tr_user_convention (
	tr_user_convention_id int(8) auto_increment NOT NULL,
	tr_user_id int(8) NULL,
	tr_convention_id int(8) NULL,
	tr_user_convention_modify_id int(8) NULL,
	tr_user_convention_modify_ts bigint NULL,
	CONSTRAINT tr_user_convention_PK PRIMARY KEY (tr_user_convention_id),
	CONSTRAINT tr_user_convention_FK FOREIGN KEY (tr_user_id) REFERENCES contafelrunde.tr_user(tr_user_id) ON DELETE RESTRICT ON UPDATE RESTRICT,
	CONSTRAINT tr_user_convention_FK_1 FOREIGN KEY (tr_user_convention_modify_id) REFERENCES contafelrunde.tr_user(tr_user_id) ON DELETE RESTRICT ON UPDATE RESTRICT,
	CONSTRAINT tr_user_convention_FK_2 FOREIGN KEY (tr_convention_id) REFERENCES contafelrunde.tr_convention(tr_convention_id) ON DELETE RESTRICT ON UPDATE RESTRICT
)
ENGINE=InnoDB
DEFAULT CHARSET=latin1
COLLATE=latin1_swedish_ci;



CREATE TABLE contafelrunde.tr_convention_event (
	tr_convention_event_id int(8) auto_increment NOT NULL,
	tr_convention_id int(8) NULL,
	tr_convention_event_start_ts bigint NULL,
	tr_convention_event_end_ts bigint NULL,
	tr_convention_event_name varchar(255) NULL,
	tr_convention_event_location varchar(255) NULL,
	tr_convention_event_text Text NULL,
	tr_convention_event_modify_id int(8) NULL,
	tr_convention_event_modify_ts bigint NULL,
	
	CONSTRAINT tr_convention_event_PK PRIMARY KEY (tr_convention_event_id),
	CONSTRAINT tr_convention_event_FK FOREIGN KEY (tr_convention_id) REFERENCES contafelrunde.tr_convention(tr_convention_id) ON DELETE RESTRICT ON UPDATE RESTRICT,
	CONSTRAINT tr_convention_event_FK_1 FOREIGN KEY (tr_convention_event_modify_id) REFERENCES contafelrunde.tr_user(tr_user_id) ON DELETE RESTRICT ON UPDATE RESTRICT
)
ENGINE=InnoDB
DEFAULT CHARSET=latin1
COLLATE=latin1_swedish_ci;


CREATE TABLE contafelrunde.tr_convention_link (
	tr_convention_link_id int(8) auto_increment NOT NULL,
	tr_convention_id int(8) NULL,
	tr_convention_link_text varchar(255) NULL,
	tr_convention_link_href varchar(255) NULL,
	tr_convention_link_modify_id int(8) NULL,
	tr_convention_link_modify_ts bigint NULL,
	CONSTRAINT tr_convention_link_PK PRIMARY KEY (tr_convention_link_id),
	CONSTRAINT tr_convention_link_FK FOREIGN KEY (tr_convention_link_modify_id) REFERENCES contafelrunde.tr_user(tr_user_id) ON DELETE RESTRICT ON UPDATE RESTRICT,
	CONSTRAINT tr_convention_link_FK_1 FOREIGN KEY (tr_convention_id) REFERENCES contafelrunde.tr_convention(tr_convention_id) ON DELETE RESTRICT ON UPDATE RESTRICT
)
ENGINE=InnoDB
DEFAULT CHARSET=latin1
COLLATE=latin1_swedish_ci;


ALTER TABLE contafelrunde.tr_convention_link ADD tr_convention_link_type int(8) NULL;
ALTER TABLE contafelrunde.tr_convention_link CHANGE tr_convention_link_type tr_convention_link_type int(8) NULL AFTER tr_convention_link_href;
ALTER TABLE contafelrunde.tr_convention_link CHANGE tr_convention_link_modify_ts tr_convention_link_modify_ts bigint(20) NULL AFTER tr_convention_link_modify_id;

ALTER TABLE contafelrunde.tr_convention_link CHANGE tr_convention_link_type tr_convention_link_type_id int(8) NULL;


CREATE TABLE contafelrunde.tr_convention_link_type (
	tr_convention_link_type_id int(8) auto_increment NOT NULL,
	tr_convention_link_type_name varchar(255) NULL,
	tr_convention_link_type_icon varchar(255) NULL,
	tr_convention_link_type_modify_id int(8) NULL,
	tr_convention_link_type_modify_ts bigint NULL,
	CONSTRAINT tr_convention_link_type_PK PRIMARY KEY (tr_convention_link_type_id),
	CONSTRAINT tr_convention_link_type_FK FOREIGN KEY (tr_convention_link_type_modify_id) REFERENCES contafelrunde.tr_user(tr_user_id) ON DELETE RESTRICT ON UPDATE RESTRICT
)
ENGINE=InnoDB
DEFAULT CHARSET=latin1
COLLATE=latin1_swedish_ci;


ALTER TABLE contafelrunde.tr_convention_link ADD CONSTRAINT tr_convention_link_FK_2 FOREIGN KEY (tr_convention_link_type_id) REFERENCES contafelrunde.tr_convention_link_type(tr_convention_link_type_id) ON DELETE RESTRICT ON UPDATE RESTRICT;


ALTER TABLE contafelrunde.tr_convention MODIFY COLUMN tr_convention_text TEXT CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL;
