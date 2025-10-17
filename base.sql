create table users(
    id int AUTO_INCREMENT primary key,
    nom varchar(50),
    email varchar(200) unique not null,
    mdp varchar(50) not null
)

create table transaction(
    id int AUTO_INCREMENT primary key,
    type varchar(50) not null,
    date_transaction datetime DEFAULT CURRENT_TIMESTAMP,
    montant decimal not null,
    description text,
    id_user int,
    foreign key (id_user) references users(id)
)
INSERT INTO transaction (type, montant, date_transaction,description, id_user) VALUES
('debit', 10 , '2024-7-08 13:38:52','Salaire du mois', 2),
('credit', 0, '2024-7-08 13:38:52','Salaire du mois', 2),
('credit', 50000,'2023-9-08 13:38:52','Achat de provisions', 1),
('debit', 0 , '2024-9-08 13:38:52','Salaire du mois', 1)


create or replace VIEW view_total_debit as
select YEAR(t1.date_transaction) as annee , MONTHNAME(t1.date_transaction) as mois ,SUM(montant) as total,t1.type ,id_user from transaction as t1
WHERE t1.type='debit'
GROUP BY MONTHNAME(t1.date_transaction) ,YEAR(t1.date_transaction) ,id_user
order by annee , mois asc

create or replace VIEW view_total_credit as
select YEAR(t2.date_transaction) as annee , MONTHNAME(t2.date_transaction) as mois ,SUM(montant) as total,t2.type ,id_user from transaction as t2
WHERE t2.type='credit'
GROUP BY MONTH(t2.date_transaction) ,YEAR(t2.date_transaction) ,id_user
order by annee , mois asc

select vtc.mois , vtc.annee ,vtc.total as credit , vtd.total as debit 
from view_total_credit as vtc
inner join view_total_debit as vtd
on vtc.annee=vtd.annee and vtc.mois=vtd.mois and vtc.id_user=vtd.id_user
where vtc.id_user=1 and vtd.id_user=1
order by annee desc , mois desc

CREATE or REPLACE VIEW view_transaction as SELECT * , MONTHNAME(date_transaction) as mois ,YEAR(`date_transaction`) as annee
FROM `transaction`