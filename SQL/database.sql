CREATE TABLE tbl_klanten(
    klantnummer int(11) AUTO_INCREMENT PRIMARY KEY NOT NULL,
    voornaam varchar(255) NOT NULL,
    achternaam varchar(255) NOT NULL,
    bedrijf varchar(255) NULL,
    wachtwoord varchar(255) NOT NULL,
    email varchar(255) NOT NULL,
    telefoonnummer varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE tbl_orders(
    ordernummer int(11) AUTO_INCREMENT PRIMARY KEY NOT NULL,
    klantnummer int(11) NOT NULL,
    breedte int(11) NOT NULL,
    hoogte int(11) NOT NULL,
    radius int(11) NOT NULL,
    tussenafstand float(11) NOT NULL,
    rolbreedte int(11) NOT NULL,
    materiaal varchar(255) NOT NULL,
    bedrukking bit(1) NOT NULL,
    afwerking varchar(11) NOT NULL,
    wikkeling int(1) NOT NULL,
    oplage int(11) NOT NULL,
    datum_aangemaakt datetime NOT NULL,
    datum_laatst_bewerkt datetime NOT NULL,
    status varchar(255) DEFAULT 'Aangevraagd' NOT NULL,
    opmerking varchar(255) NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
