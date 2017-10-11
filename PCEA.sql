#------------------------------------------------------------
#        Script MySQL.
#------------------------------------------------------------


#------------------------------------------------------------
# Table: Tusers
#------------------------------------------------------------

CREATE TABLE Tusers(
        idUser    int (11) Auto_increment  NOT NULL ,
        username  Varchar (25) NOT NULL ,
        password  Varchar (25) NOT NULL ,
        firstname Varchar (25) ,
        lastname  Varchar (25) ,
        PRIMARY KEY (idUser ) ,
        UNIQUE (username )
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Tevents
#------------------------------------------------------------

CREATE TABLE Tevents(
        idEvent   int (11) Auto_increment  NOT NULL ,
        nameEvent Varchar (25) NOT NULL ,
        idGroup   Int NOT NULL ,
        PRIMARY KEY (idEvent )
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Tgroups
#------------------------------------------------------------

CREATE TABLE Tgroups(
        idGroup   int (11) Auto_increment  NOT NULL ,
        nameGroup Varchar (25) NOT NULL ,
        PRIMARY KEY (idGroup )
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Tcurrencies
#------------------------------------------------------------

CREATE TABLE Tcurrencies(
        idCurrency   int (11) Auto_increment  NOT NULL ,
        nameCurrency Varchar (25) NOT NULL ,
        abbvCurrency Varchar (25) ,
        PRIMARY KEY (idCurrency )
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: TpaymentNature
#------------------------------------------------------------

CREATE TABLE TpaymentNature(
        idPayementNature   int (11) Auto_increment  NOT NULL ,
        namePayementNature Varchar (25) NOT NULL ,
        PRIMARY KEY (idPayementNature ) ,
        UNIQUE (namePayementNature )
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Tpayments
#------------------------------------------------------------

CREATE TABLE Tpayments(
        idPayment        int (11) Auto_increment  NOT NULL ,
        amount           Float NOT NULL ,
        datePayment      Date NOT NULL ,
        idPayementNature Int ,
        idCurrency       Int NOT NULL ,
        PRIMARY KEY (idPayment )
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: inGroup
#------------------------------------------------------------

CREATE TABLE inGroup(
        weight  Int NOT NULL ,
        idUser  Int NOT NULL ,
        idGroup Int NOT NULL ,
        PRIMARY KEY (idUser ,idGroup )
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: havePayment
#------------------------------------------------------------

CREATE TABLE havePayment(
        idEvent   Int NOT NULL ,
        idPayment Int NOT NULL ,
        idUser    Int NOT NULL ,
        PRIMARY KEY (idEvent ,idPayment ,idUser )
)ENGINE=InnoDB;

ALTER TABLE Tevents ADD CONSTRAINT FK_Tevents_idGroup FOREIGN KEY (idGroup) REFERENCES Tgroups(idGroup);
ALTER TABLE Tpayments ADD CONSTRAINT FK_Tpayments_idPayementNature FOREIGN KEY (idPayementNature) REFERENCES TpaymentNature(idPayementNature);
ALTER TABLE Tpayments ADD CONSTRAINT FK_Tpayments_idCurrency FOREIGN KEY (idCurrency) REFERENCES Tcurrencies(idCurrency);
ALTER TABLE inGroup ADD CONSTRAINT FK_inGroup_idUser FOREIGN KEY (idUser) REFERENCES Tusers(idUser);
ALTER TABLE inGroup ADD CONSTRAINT FK_inGroup_idGroup FOREIGN KEY (idGroup) REFERENCES Tgroups(idGroup);
ALTER TABLE havePayment ADD CONSTRAINT FK_havePayment_idEvent FOREIGN KEY (idEvent) REFERENCES Tevents(idEvent);
ALTER TABLE havePayment ADD CONSTRAINT FK_havePayment_idPayment FOREIGN KEY (idPayment) REFERENCES Tpayments(idPayment);
ALTER TABLE havePayment ADD CONSTRAINT FK_havePayment_idUser FOREIGN KEY (idUser) REFERENCES Tusers(idUser);
