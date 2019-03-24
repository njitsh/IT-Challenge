CREATE TABLE tbl_klanten(
    klantnummer int(11) AUTO_INCREMENT PRIMARY KEY NOT NULL,
    voornaam varchar(256) NOT NULL,
    achternaam varchar(256) NOT NULL,
    bedrijf varchar(256),
    adres varchar(256) NOT NULL,
    wachtwoord varchar(256) NOT NULL,
    email varchar(256) NOT NULL,
    telefoonnummer varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE tbl_orders(
    ordernummer int(11) AUTO_INCREMENT PRIMARY KEY NOT NULL,
    klantnummer int(11) NOT NULL,
    breedte int(11) NOT NULL,
    hoogte int(11) NOT NULL,
    radius int(11) NOT NULL,
    tussenafstand float(11) NOT NULL,
    rolbreedte int(11) NOT NULL,
    materiaal varchar(256) NOT NULL,
    afbeelding_path varchar(256) NULL,
    afwerking varchar(11) NOT NULL,
    wikkeling int(1) NOT NULL,
    oplage1 int(11) NOT NULL,
    oplage2 int(11) NOT NULL,
    datum_aangemaakt datetime NOT NULL,
    datum_laatst_bewerkt datetime NOT NULL,
    status varchar(256) DEFAULT 'Aangevraagd' NOT NULL,
    opmerking_klant varchar(256) NULL,
    opmerking_admin varchar(256) NULL,
    is_order bit(1) DEFAULT 0 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE tbl_materialen(
    materiaalnummer int(11) AUTO_INCREMENT PRIMARY KEY NOT NULL,
    materiaal varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE tbl_afwerking(
    afwerkingnummer  int(11) AUTO_INCREMENT PRIMARY KEY NOT NULL,
    afwerking varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE tbl_fabrikanten(
    fabrikantnummer int(11) AUTO_INCREMENT PRIMARY KEY NOT NULL,
    fabrikant varchar(256) NOT NULL,
    contactpersoon varchar(256) NOT NULL,
    telefoonnummer varchar(256) NOT NULL,
    email varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
