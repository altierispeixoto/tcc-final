DROP SCHEMA PUBLIC CASCADE;
CREATE SCHEMA PUBLIC;

/**********************************/
/* Table Name: area_medica */
/**********************************/
CREATE TABLE public.area_medica(
  id_area_medica SERIAL NOT NULL PRIMARY KEY,
  area VARCHAR(60) NOT NULL UNIQUE,
  status INTEGER NOT NULL
);

/**********************************/
/* Table Name: subarea */
/**********************************/
CREATE TABLE public.subarea(
  id_subarea SERIAL,
  id_area_medica INTEGER,
  descricao VARCHAR(20) NOT NULL UNIQUE,
  status INTEGER NOT NULL,
  PRIMARY KEY (id_subarea, id_area_medica),
  FOREIGN KEY (id_area_medica) REFERENCES public.area_medica (id_area_medica)
);

/**********************************/
/* Table Name: idx_patologia */
/**********************************/
CREATE TABLE public.idx_patologia(
  id_patologia SERIAL PRIMARY KEY,
  id_subarea INTEGER not null,
  id_area_medica INTEGER not null, 
  descricao VARCHAR(60) NOT NULL UNIQUE,
  status INTEGER NOT NULL,
  FOREIGN KEY (id_subarea,id_area_medica) REFERENCES public.subarea (id_subarea,id_area_medica)
);

/**********************************/
/* Table Name: imagem */
/**********************************/
CREATE TABLE public.imagem(
  id_imagem SERIAL PRIMARY KEY,
  id_patologia INTEGER NOT NULL,
  observacao TEXT,
  diagnostico TEXT,
  categoria varchar(4),
  composicao varchar(2),
  imagem OID NOT NULL,
  dt_upload date not null,
  status INTEGER NOT NULL,
  FOREIGN KEY (id_patologia) REFERENCES public.idx_patologia (id_patologia)
);

/**********************************/
/* Table Name: login */
/**********************************/
CREATE TABLE public.login(
  username VARCHAR(15) PRIMARY KEY,
  password VARCHAR(32) NOT NULL,
  nv_acess INTEGER NOT NULL,
  status INTEGER NOT NULL
);

/**********************************/
/* Table Name: login_area_medica */
/**********************************/
CREATE TABLE public.login_area_medica(
  username VARCHAR(15),
  id_area_medica INTEGER,
  PRIMARY KEY(username,id_area_medica),
  FOREIGN KEY (username) REFERENCES public.login (username),
  FOREIGN KEY (id_area_medica) REFERENCES public.area_medica (id_area_medica)
);

/**********************************/
/* Table Name: usuario */
/**********************************/
CREATE TABLE public.usuario(
  id_usuario SERIAL PRIMARY KEY,
  nome VARCHAR(50) NOT NULL,
  email VARCHAR(50) NOT NULL,
  username VARCHAR(15),
  status integer not null,
  FOREIGN KEY (username) REFERENCES public.login (username)
);

/*******************************/
/* TABLE Name: login_imagem    */
/*******************************/
CREATE TABLE public.login_imagem(
	username varchar(15),
	id_imagem integer,
	primary key(username,id_imagem),
	foreign key (username) references public.login(username),
	foreign key (id_imagem) references public.imagem(id_imagem)
);

------------------------------------------------------------------------------------------
/* [[ funcao de desativacao de usuario de usuario ]] */
create function desativa_usuario() returns trigger as
$$
begin
  update usuario set status = new.status where username = old.username;
  return null;
end;  
$$
language plpgsql;

/* [[ trigger de desativacao de usuario ]] */
create trigger tg_desativa_usuario after update on login for each row execute procedure desativa_usuario(); 

----------------------------------------------------------------------------------------  
/* [[funcao de desativacao de subarea medica ]] */
create function desativa_subarea() returns trigger as
$$
begin
	update subarea set status = 0 where id_area_medica = old.id_area_medica;
	return null;
end;
$$
language plpgsql;

/* [[ trigger de desativacao de subarea medica]] */
create trigger tg_desativa_subarea after update on area_medica for each row execute procedure desativa_subarea();

-----------------------------------------------------------------------------------------
/* [[ Tipo criado para a funcao de grafico de imagens por Area Medica ]] */
CREATE TYPE imagensArea as(
nimagens BIGINT,
area varchar(60)
);


/* [[ funcao de grafico de imagens por Area Medica ]] */
CREATE OR REPLACE FUNCTION graficoAreaMedica()RETURNS SETOF imagensArea AS $$
DECLARE 
grafico imagensArea;
BEGIN
   FOR grafico IN SELECT COUNT(i.id_imagem),a.area
               FROM idx_patologia p 
               INNER JOIN area_medica a ON (p.id_area_medica = a.id_area_medica)
               INNER JOIN imagem i ON (i.id_patologia = p.id_patologia)
               AND p.status = 1 and a.status = 1 and i.status = 1
               GROUP BY a.area
   LOOP
    RETURN NEXT grafico;
   END LOOP;
END;
$$
LANGUAGE 'plpgsql'

-----------------------------------------------------------------------------------------
/* [[ tipo criado para a funcao de relatorio de usuarios ]] */
CREATE TYPE relatorio_usuario as (
	id_usuario INTEGER,
    nome VARCHAR(60),
    nv_acess INTEGER,
    email  VARCHAR(50),
    username VARCHAR(15)
);

/* [[ funcao que gera o relatorio de usuarios ativos do sistema ]] */
CREATE OR REPLACE FUNCTION relatorio_usuarios_ativos() RETURNS SETOF relatorio_usuario AS $$
DECLARE
 relatorio relatorio_usuario;
 BEGIN
    FOR relatorio IN SELECT u.id_usuario,u.nome,l.nv_acess,u.email,l.username
              		 FROM usuario u
               		 INNER JOIN  login l ON (u.username = l.username)
               		 AND l.status = 1
                     AND u.status = 1
                     ORDER BY u.nome ASC LOOP 
                     RETURN NEXT relatorio;
                     END LOOP;
 END;
 $$
 LANGUAGE 'plpgsql'

---------------------------------------------------------------------------------------
/* [[ VIEW PARA LISTAGEM DA TABELA DE USUARIOS ATIVOS NO SISTEMA ]] */
CREATE OR REPLACE VIEW "public"."tb_usuarios" (
    id_usuario,
    nome,
    username,
    email,
    nv_acess,
    status)
AS
 SELECT u.id_usuario,
        u.nome,
        u.username,
        u.email,
        l.nv_acess,
        l.status
 FROM usuario u,
      login l
 WHERE (u.username) ::text =(l.username) ::text AND
       l.status = 1 AND
       u.status = 1
 ORDER BY u.nome;

-- Dados iniciais para utilizacao do sistema

insert into login values('altieris',md5('teste'),3,1);
insert into usuario values(default,'Altieris Marcelino Peixoto','altieris.marcelino@yahoo.com.br','altieris',1);
insert into login values ('SYSTEM',md5('adminadmin'),4,1);
insert into usuario values(default,'SYSTEM','','SYSTEM',1);
insert into area_medica values(default,'Ginecologia',1);
insert into subarea values(default,1,'Mamografia',1);
insert into idx_patologia values(default,1,1,'Bi-Rads',1);