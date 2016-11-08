/* Inainte sa copiati fisierele rulati sriptul aceasta. Daca aveti reviewuri in sistem si nu vreti sa stergeti rulati scriptul oc_review2*/
ALTER TABLE oc_review ADD ip varchar(255) NOT NULL;
ALTER TABLE oc_review ADD bought tinyint(1) NOT NULL; 
ALTER TABLE oc_review ADD title varchar(255);