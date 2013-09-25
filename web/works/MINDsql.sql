CREATE TABLE Domaine (
  idDomaine INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  nomDomaine VARCHAR(20) NULL,
  etat BOOL NULL,
  image VARCHAR(255) NULL,
  PRIMARY KEY(idDomaine)
);

CREATE TABLE Membre (
  idMembre INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  nom VARCHAR(45) NULL,
  prenom VARCHAR(45) NULL,
  adresse VARCHAR(255) NULL,
  email VARCHAR(45) NULL,
  mdp VARCHAR(255) NULL,
  pseudo VARCHAR(255) NULL,
  datedenaissance DATE NULL,
  rang INTEGER UNSIGNED NULL,
  PRIMARY KEY(idMembre)
);

CREATE TABLE Sujet (
  idSujet INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  libelle VARCHAR(45) NULL,
  PRIMARY KEY(idSujet)
);

CREATE TABLE Message (
  idMessage INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  Membre_idMembre INTEGER UNSIGNED NOT NULL,
  idExpediteur INTEGER UNSIGNED NULL,
  idDestinataire INTEGER UNSIGNED NULL,
  objet VARCHAR(255) NULL,
  contenu TEXT NULL,
  PRIMARY KEY(idMessage),
  INDEX #idExpedieur(Membre_idMembre),
  INDEX #iddestinataire(Membre_idMembre),
  FOREIGN KEY(Membre_idMembre)
    REFERENCES Membre(idMembre)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION,
  FOREIGN KEY(Membre_idMembre)
    REFERENCES Membre(idMembre)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION
);

ATTENTION : pensez à une table conversatio et dans cette conversation on séchange des méssage

CREATE TABLE Abonnement (
  Domaine_idDomaine INTEGER UNSIGNED NOT NULL,
  Membre_idMembre INTEGER UNSIGNED NOT NULL,
  PRIMARY KEY(Domaine_idDomaine, Membre_idMembre),
  INDEX Abonnement_FKIndex1(Domaine_idDomaine),
  INDEX Abonnement_FKIndex2(Membre_idMembre),
  FOREIGN KEY(Domaine_idDomaine)
    REFERENCES Domaine(idDomaine)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION,
  FOREIGN KEY(Membre_idMembre)
    REFERENCES Membre(idMembre)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION
);

CREATE TABLE Avis (
  idAvis INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  Membre_idMembre INTEGER UNSIGNED NOT NULL,
  Domaine_idDomaine INTEGER UNSIGNED NOT NULL,
  Sujet_idSujet INTEGER UNSIGNED NOT NULL,
  type_2 VARCHAR(20) NULL,
  description TEXT NULL,
  PRIMARY KEY(idAvis),
  INDEX #idSujet(Sujet_idSujet),
  INDEX #idDomaine(Domaine_idDomaine),
  INDEX #idMembre(Membre_idMembre),
  FOREIGN KEY(Sujet_idSujet)
    REFERENCES Sujet(idSujet)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION,
  FOREIGN KEY(Domaine_idDomaine)
    REFERENCES Domaine(idDomaine)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION,
  FOREIGN KEY(Membre_idMembre)
    REFERENCES Membre(idMembre)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION
);

CREATE TABLE Question (
  idQuestion INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  Membre_idMembre INTEGER UNSIGNED NOT NULL,
  Domaine_idDomaine INTEGER UNSIGNED NOT NULL,
  Sujet_idSujet INTEGER UNSIGNED NOT NULL,
  description TEXT NULL,
  PRIMARY KEY(idQuestion),
  INDEX Question_FKIndex1(Sujet_idSujet),
  INDEX Question_FKIndex2(Domaine_idDomaine),
  INDEX Question_FKIndex3(Membre_idMembre),
  FOREIGN KEY(Sujet_idSujet)
    REFERENCES Sujet(idSujet)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION,
  FOREIGN KEY(Domaine_idDomaine)
    REFERENCES Domaine(idDomaine)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION,
  FOREIGN KEY(Membre_idMembre)
    REFERENCES Membre(idMembre)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION
);

CREATE TABLE Opinion (
  Avis_idAvis INTEGER UNSIGNED NOT NULL,
  Membre_idMembre INTEGER UNSIGNED NOT NULL,
  type_2 VARCHAR(20) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY(Avis_idAvis, Membre_idMembre),
  INDEX Opinion_FKIndex1(Avis_idAvis),
  INDEX Opinion_FKIndex2(Membre_idMembre),
  FOREIGN KEY(Avis_idAvis)
    REFERENCES Avis(idAvis)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION,
  FOREIGN KEY(Membre_idMembre)
    REFERENCES Membre(idMembre)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION
);

CREATE TABLE CommentairesQuestions (
  idCommentaire INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  Membre_idMembre INTEGER UNSIGNED NOT NULL,
  Question_idQuestion INTEGER UNSIGNED NOT NULL,
  libelle TEXT NULL,
  PRIMARY KEY(idCommentaire),
  INDEX CommentairesQuestions_FKIndex1(Question_idQuestion),
  INDEX CommentairesQuestions_FKIndex2(Membre_idMembre),
  FOREIGN KEY(Question_idQuestion)
    REFERENCES Question(idQuestion)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION,
  FOREIGN KEY(Membre_idMembre)
    REFERENCES Membre(idMembre)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION
);

CREATE TABLE CommentaireAvis (
  idCommentaire INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  Membre_idMembre INTEGER UNSIGNED NOT NULL,
  Avis_idAvis INTEGER UNSIGNED NOT NULL,
  libelle TEXT NULL,
  PRIMARY KEY(idCommentaire),
  INDEX #idAvis(Avis_idAvis),
  INDEX #idMembre(Membre_idMembre),
  FOREIGN KEY(Avis_idAvis)
    REFERENCES Avis(idAvis)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION,
  FOREIGN KEY(Membre_idMembre)
    REFERENCES Membre(idMembre)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION
);


