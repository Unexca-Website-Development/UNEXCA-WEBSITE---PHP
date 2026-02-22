--
-- PostgreSQL database dump
--

\restrict 8zYqThvCjtnb2MNbpvgGwhc1mdBPv8Vor5QacjZ33VBgdDpLDcyoz658isOkAqn

-- Dumped from database version 18.0
-- Dumped by pg_dump version 18.0

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET transaction_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

--
-- Name: obtener_id(text, text, text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.obtener_id(tabla text, campo text, valor text) RETURNS integer
    LANGUAGE plpgsql
    AS $_$
DECLARE
  id_result INTEGER;
  consulta TEXT;
BEGIN
  -- Validación básica: evita SQL injection con format y %I
  consulta := format(
    'SELECT id FROM %I WHERE %I ILIKE $1 LIMIT 1',
    tabla, campo
  );

  EXECUTE consulta INTO id_result USING '%' || valor || '%';

  IF id_result IS NULL THEN
    RAISE EXCEPTION 'No se encontró registro en %.% con valor que contenga: %', tabla, campo, valor;
  END IF;

  RETURN id_result;
END;
$_$;


ALTER FUNCTION public.obtener_id(tabla text, campo text, valor text) OWNER TO postgres;

--
-- Name: obtener_id_carrera(character varying); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.obtener_id_carrera(titulo_input character varying) RETURNS integer
    LANGUAGE plpgsql
    AS $$
DECLARE
  carrera_id INTEGER;
BEGIN
  SELECT id INTO carrera_id
  FROM carrera
  WHERE titulo ILIKE '%' || titulo_input || '%';

  IF carrera_id IS NULL THEN
    RAISE EXCEPTION 'Carrera con titulo % no encontrada', titulo_input;
  END IF;

  RETURN carrera_id;
END;
$$;


ALTER FUNCTION public.obtener_id_carrera(titulo_input character varying) OWNER TO postgres;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- Name: autoridades_academicas; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.autoridades_academicas (
    id integer NOT NULL,
    nombre character varying(255) NOT NULL,
    cargo character varying(255) NOT NULL,
    imagen character varying(500)
);


ALTER TABLE public.autoridades_academicas OWNER TO postgres;

--
-- Name: autoridades_academicas_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.autoridades_academicas_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.autoridades_academicas_id_seq OWNER TO postgres;

--
-- Name: autoridades_academicas_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.autoridades_academicas_id_seq OWNED BY public.autoridades_academicas.id;


--
-- Name: carrera; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.carrera (
    id integer NOT NULL,
    titulo character varying(255) NOT NULL,
    descripcion text,
    link_malla_curricular character varying(500),
    imagen character varying(500),
    slug character varying(255)
);


ALTER TABLE public.carrera OWNER TO postgres;

--
-- Name: carrera_id; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.carrera_id (
    id integer
);


ALTER TABLE public.carrera_id OWNER TO postgres;

--
-- Name: carrera_niveles_academicos; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.carrera_niveles_academicos (
    id integer NOT NULL,
    carrera_id integer NOT NULL,
    nivel character varying(50) NOT NULL,
    duracion character varying(100) NOT NULL,
    diploma character varying(255) NOT NULL
);


ALTER TABLE public.carrera_niveles_academicos OWNER TO postgres;

--
-- Name: carrera_niveles_academicos_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.carrera_niveles_academicos_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.carrera_niveles_academicos_id_seq OWNER TO postgres;

--
-- Name: carrera_niveles_academicos_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.carrera_niveles_academicos_id_seq OWNED BY public.carrera_niveles_academicos.id;


--
-- Name: carrera_nucleos; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.carrera_nucleos (
    id integer NOT NULL,
    carrera_id integer NOT NULL,
    nucleo_id integer NOT NULL
);


ALTER TABLE public.carrera_nucleos OWNER TO postgres;

--
-- Name: carrera_nucleos_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.carrera_nucleos_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.carrera_nucleos_id_seq OWNER TO postgres;

--
-- Name: carrera_nucleos_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.carrera_nucleos_id_seq OWNED BY public.carrera_nucleos.id;


--
-- Name: carrera_parrafos; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.carrera_parrafos (
    id integer NOT NULL,
    carrera_id integer NOT NULL,
    numero_parrafo integer,
    contenido text
);


ALTER TABLE public.carrera_parrafos OWNER TO postgres;

--
-- Name: carrera_parrafos_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.carrera_parrafos_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.carrera_parrafos_id_seq OWNER TO postgres;

--
-- Name: carrera_parrafos_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.carrera_parrafos_id_seq OWNED BY public.carrera_parrafos.id;


--
-- Name: carrera_turnos; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.carrera_turnos (
    id integer NOT NULL,
    carrera_id integer NOT NULL,
    turno character varying(100)
);


ALTER TABLE public.carrera_turnos OWNER TO postgres;

--
-- Name: carrera_turnos_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.carrera_turnos_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.carrera_turnos_id_seq OWNER TO postgres;

--
-- Name: carrera_turnos_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.carrera_turnos_id_seq OWNED BY public.carrera_turnos.id;


--
-- Name: carreras_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.carreras_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.carreras_id_seq OWNER TO postgres;

--
-- Name: carreras_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.carreras_id_seq OWNED BY public.carrera.id;


--
-- Name: contactos_coordinadores_pnf; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.contactos_coordinadores_pnf (
    id integer NOT NULL,
    nombre_completo character varying(255) NOT NULL,
    titulo_academico character varying(100),
    telefono character varying(50),
    email character varying(255),
    oficina text,
    horario_atencion text,
    nucleo_id integer,
    carrera_id integer
);


ALTER TABLE public.contactos_coordinadores_pnf OWNER TO postgres;

--
-- Name: contactos_coordinadores_pnf_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.contactos_coordinadores_pnf_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.contactos_coordinadores_pnf_id_seq OWNER TO postgres;

--
-- Name: contactos_coordinadores_pnf_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.contactos_coordinadores_pnf_id_seq OWNED BY public.contactos_coordinadores_pnf.id;


--
-- Name: contactos_directivos; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.contactos_directivos (
    id integer NOT NULL,
    nombre_completo character varying(255) NOT NULL,
    cargo character varying(255) NOT NULL,
    telefono character varying(50),
    email character varying(255),
    oficina text,
    nucleo_id integer
);


ALTER TABLE public.contactos_directivos OWNER TO postgres;

--
-- Name: contactos_directivos_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.contactos_directivos_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.contactos_directivos_id_seq OWNER TO postgres;

--
-- Name: contactos_directivos_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.contactos_directivos_id_seq OWNED BY public.contactos_directivos.id;


--
-- Name: faqs; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.faqs (
    id integer NOT NULL,
    pregunta text NOT NULL,
    respuesta text NOT NULL
);


ALTER TABLE public.faqs OWNER TO postgres;

--
-- Name: faqs_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.faqs_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.faqs_id_seq OWNER TO postgres;

--
-- Name: faqs_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.faqs_id_seq OWNED BY public.faqs.id;


--
-- Name: menu_enlaces_dinamicos; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.menu_enlaces_dinamicos (
    id integer NOT NULL,
    menu_id integer NOT NULL,
    titulo character varying(255) NOT NULL,
    url character varying(255) NOT NULL,
    tabla_origen character varying(50),
    registro_id integer,
    padre_id integer,
    orden integer DEFAULT 0
);


ALTER TABLE public.menu_enlaces_dinamicos OWNER TO postgres;

--
-- Name: menu_enlaces_dinamicos_id_seq1; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.menu_enlaces_dinamicos_id_seq1
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.menu_enlaces_dinamicos_id_seq1 OWNER TO postgres;

--
-- Name: menu_enlaces_dinamicos_id_seq1; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.menu_enlaces_dinamicos_id_seq1 OWNED BY public.menu_enlaces_dinamicos.id;


--
-- Name: menu_enlaces_estaticos; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.menu_enlaces_estaticos (
    id integer NOT NULL,
    menu_id integer NOT NULL,
    titulo character varying(255) NOT NULL,
    url character varying(500),
    padre_id integer,
    orden integer DEFAULT 0
);


ALTER TABLE public.menu_enlaces_estaticos OWNER TO postgres;

--
-- Name: menu_enlaces_estaticos_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.menu_enlaces_estaticos_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.menu_enlaces_estaticos_id_seq OWNER TO postgres;

--
-- Name: menu_enlaces_estaticos_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.menu_enlaces_estaticos_id_seq OWNED BY public.menu_enlaces_estaticos.id;


--
-- Name: menus; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.menus (
    id integer NOT NULL,
    nombre character varying(50) NOT NULL,
    descripcion text
);


ALTER TABLE public.menus OWNER TO postgres;

--
-- Name: menus_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.menus_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.menus_id_seq OWNER TO postgres;

--
-- Name: menus_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.menus_id_seq OWNED BY public.menus.id;


--
-- Name: noticias; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.noticias (
    noticia_id integer NOT NULL,
    titulo_principal character varying(255) NOT NULL,
    descripcion_corta text NOT NULL,
    imagen_principal text NOT NULL,
    descripcion_imagen text,
    url text NOT NULL,
    fecha_creacion timestamp without time zone DEFAULT now() NOT NULL,
    fecha_publicacion timestamp without time zone,
    fecha_modificacion timestamp without time zone
);


ALTER TABLE public.noticias OWNER TO postgres;

--
-- Name: noticias_contenido; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.noticias_contenido (
    contenido_id integer NOT NULL,
    noticia_id integer NOT NULL,
    tipo_bloque character varying(50) NOT NULL,
    datos jsonb NOT NULL,
    posicion integer NOT NULL
);


ALTER TABLE public.noticias_contenido OWNER TO postgres;

--
-- Name: noticias_contenido_contenido_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.noticias_contenido_contenido_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.noticias_contenido_contenido_id_seq OWNER TO postgres;

--
-- Name: noticias_contenido_contenido_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.noticias_contenido_contenido_id_seq OWNED BY public.noticias_contenido.contenido_id;


--
-- Name: noticias_noticia_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.noticias_noticia_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.noticias_noticia_id_seq OWNER TO postgres;

--
-- Name: noticias_noticia_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.noticias_noticia_id_seq OWNED BY public.noticias.noticia_id;


--
-- Name: nucleos; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.nucleos (
    id integer NOT NULL,
    nombre character varying(255) NOT NULL
);


ALTER TABLE public.nucleos OWNER TO postgres;

--
-- Name: nucleos_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.nucleos_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.nucleos_id_seq OWNER TO postgres;

--
-- Name: nucleos_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.nucleos_id_seq OWNED BY public.nucleos.id;


--
-- Name: servicios; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.servicios (
    id integer NOT NULL,
    servicio text NOT NULL,
    respuesta text NOT NULL
);


ALTER TABLE public.servicios OWNER TO postgres;

--
-- Name: servicios_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.servicios_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.servicios_id_seq OWNER TO postgres;

--
-- Name: servicios_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.servicios_id_seq OWNED BY public.servicios.id;


--
-- Name: autoridades_academicas id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.autoridades_academicas ALTER COLUMN id SET DEFAULT nextval('public.autoridades_academicas_id_seq'::regclass);


--
-- Name: carrera id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.carrera ALTER COLUMN id SET DEFAULT nextval('public.carreras_id_seq'::regclass);


--
-- Name: carrera_niveles_academicos id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.carrera_niveles_academicos ALTER COLUMN id SET DEFAULT nextval('public.carrera_niveles_academicos_id_seq'::regclass);


--
-- Name: carrera_nucleos id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.carrera_nucleos ALTER COLUMN id SET DEFAULT nextval('public.carrera_nucleos_id_seq'::regclass);


--
-- Name: carrera_parrafos id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.carrera_parrafos ALTER COLUMN id SET DEFAULT nextval('public.carrera_parrafos_id_seq'::regclass);


--
-- Name: carrera_turnos id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.carrera_turnos ALTER COLUMN id SET DEFAULT nextval('public.carrera_turnos_id_seq'::regclass);


--
-- Name: contactos_coordinadores_pnf id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.contactos_coordinadores_pnf ALTER COLUMN id SET DEFAULT nextval('public.contactos_coordinadores_pnf_id_seq'::regclass);


--
-- Name: contactos_directivos id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.contactos_directivos ALTER COLUMN id SET DEFAULT nextval('public.contactos_directivos_id_seq'::regclass);


--
-- Name: faqs id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.faqs ALTER COLUMN id SET DEFAULT nextval('public.faqs_id_seq'::regclass);


--
-- Name: menu_enlaces_dinamicos id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.menu_enlaces_dinamicos ALTER COLUMN id SET DEFAULT nextval('public.menu_enlaces_dinamicos_id_seq1'::regclass);


--
-- Name: menu_enlaces_estaticos id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.menu_enlaces_estaticos ALTER COLUMN id SET DEFAULT nextval('public.menu_enlaces_estaticos_id_seq'::regclass);


--
-- Name: menus id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.menus ALTER COLUMN id SET DEFAULT nextval('public.menus_id_seq'::regclass);


--
-- Name: noticias noticia_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.noticias ALTER COLUMN noticia_id SET DEFAULT nextval('public.noticias_noticia_id_seq'::regclass);


--
-- Name: noticias_contenido contenido_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.noticias_contenido ALTER COLUMN contenido_id SET DEFAULT nextval('public.noticias_contenido_contenido_id_seq'::regclass);


--
-- Name: nucleos id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.nucleos ALTER COLUMN id SET DEFAULT nextval('public.nucleos_id_seq'::regclass);


--
-- Name: servicios id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.servicios ALTER COLUMN id SET DEFAULT nextval('public.servicios_id_seq'::regclass);


--
-- Data for Name: autoridades_academicas; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.autoridades_academicas (id, nombre, cargo, imagen) FROM stdin;
1	Dr. Rúben Darío Reinoso Ratjes	Rector	autoridad_1.jpg
2	Msc. Haydee Corova Rivero	Vicerrectora para el Desarrollo Académico	autoridad_2.jpg
3	Dr. Ivonne Gómez	Vicerrector de Producción y Comunas	autoridad_3.jpg
4	Esp. Gamal El Hennaoui	Secretario General	autoridad_4.jpg
5	E. Néstor Chacón	Vicerrector de Investigación y Postgrado	autoridad_5.jpg
6	Eneyda Arreaza	Directora del núcleo La Urbina UNEXCA	autoridad_6.jpg
7	Maria Blanco	Directora del núcleo La Floresta UNEXCA	autoridad_7.jpg
8	Marta Ávila	Directora del núcleo Altagracia UNEXCA	autoridad_8.jpg
\.


--
-- Data for Name: carrera; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.carrera (id, titulo, descripcion, link_malla_curricular, imagen, slug) FROM stdin;
1	Distribución y Logística	Conforma y conduce organizaciones. Fortalece la economía social en sus procesos administrativos, productivos, económicos y financieros.	\N	distribucion-y-logistica.jpg	distribucion-y-logistica
2	Trabajo Social	Organiza, planifica, orienta, evalúa, investiga y dirige los procesos orientados a la atención integral e integradora de la población vulnerable.	\N	trabajo-social.jpg	trabajo-social
3	Administración	Identifica, analiza y soluciona problemas del ámbito administrativo, con aptitudes para desempeñar en planificación, organización, dirección, control y evaluación.	\N	administracion.jpg	administracion
4	Ing. Informática	Conceptualiza y construye productos tecnológicos informáticos. Desarrolla e implementa software priorizando el uso de plataformas libres.	\N	ing-informatica.jpg	ing-informatica
5	Turismo	Fórmate para el emprendimiento, la investigación, gestión de políticas y proyectos en comunidades e influye positivamente en el desarrollo turístico endógeno.	\N	turismo.jpg	turismo
6	Contaduría	Adquiere profundos conocimientos de las Ciencias Contables y Sociales para ser capaz de elaborar, revisar, examinar, presentar y dar fe pública de la información financiera de identidades públicas y privadas.	\N	contaduria.jpg	contaduria
7	Educación Inicial	Adquiere una sólida formación con enfoque crítico, ecológico y de carácter preventivo, éticamente comprometida para la formación inicial de los ciudadanos.	\N	educacion-inicial.jpg	educacion-inicial
8	Educación Especial	Aprende procesos multidimensionales relacionados con la formación integral para conservar la salud de educados con necesidades educativas especiales en contextos diversos.	\N	educacion-especial.jpg	educacion-especial
9	Ing. Agroalimentaria	Investiga la evolución y métodos para obtener productos aptos para el consumo humano, los efectos químicos, biológicos y físicos que intervienen en la obtención y conservación de los mismos.	\N	ing-agroalimentaria.jpg	ing-agroalimentaria
\.


--
-- Data for Name: carrera_id; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.carrera_id (id) FROM stdin;
\.


--
-- Data for Name: carrera_niveles_academicos; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.carrera_niveles_academicos (id, carrera_id, nivel, duracion, diploma) FROM stdin;
9	9	TSU	2 años	TSU en Agroalimentaria
10	9	Ingeniería	4 años	Ingeniero/a Agroalimentario/a
13	2	TSU	2 años	TSU en Trabajo Social
14	2	Licenciatura	4 años	Licenciado/a en Trabajo Social
15	5	TSU	2 años	TSU en Turismo
16	5	Licenciatura	4 años	Licenciado/a en Turismo
1	3	TSU	2 años	TSU en Administración
2	3	Licenciatura	4 años	Licenciado/a en Administración
3	6	TSU	2 años	TSU en Contaduría
4	6	Licenciatura	4 años	Licenciado/a en Contaduría
5	1	TSU	2 años	TSU en Distribución y Logística
6	1	Licenciatura	4 años	Licenciado/a en Distribución y Logística
7	8	Licenciatura	4 años	Licenciado/a en Educación Especial
8	7	TSU	2 años	TSU en Educación Inicial
11	4	TSU	2 años	TSU en Informática
12	4	Ingeniería	4 años	Ingeniero/a en Informática
\.


--
-- Data for Name: carrera_nucleos; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.carrera_nucleos (id, carrera_id, nucleo_id) FROM stdin;
1	3	1
2	3	2
3	3	3
4	3	4
5	6	1
6	6	4
7	1	1
8	1	2
9	1	3
10	1	4
11	8	3
12	8	4
13	7	2
14	7	4
15	9	1
16	9	4
17	4	1
18	4	2
19	4	4
20	2	1
21	2	4
22	5	2
23	5	3
24	5	4
\.


--
-- Data for Name: carrera_parrafos; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.carrera_parrafos (id, carrera_id, numero_parrafo, contenido) FROM stdin;
1	3	1	Los egresados y las egresadas del Programa Nacional de Formación en Administración son profesionales que identifican, analizan y solucionan problemas propios del ámbito administrativo, con aptitudes para desempeñarse operativamente en las fases del proceso administrativo: planificación, organización, dirección, control y evaluación; vinculando estas fases a las áreas contables, financieras y productivas.
2	6	1	Los egresados o las egresadas del Programa Nacional de Formación en Contaduría Pública son ciudadanos integrales con valores altamente humanísticos, dinámicos, emprendedores, con profundos conocimientos de las Ciencias Contables y Sociales relacionadas con la profesión.
3	6	2	Son capaces de elaborar, revisar, examinar y presentar la información financiera que permita dar fe pública de la razonabilidad de la misma.
4	6	3	Actúan de manera proactiva y estratégica, dispuestos y comprometidos a aportar y construir soluciones en el marco de los nuevos paradigmas de la ciencia contable en entidades públicas y privadas, de producción social, colectivas, entre otros, relacionadas con los procesos de gestión, presupuestarios, productivos y financieros de las entidades.
5	1	1	Los egresados y las egresadas del PNF en Distribución y Logística son profesionales integrales que aprenden a conformar y conducir organizaciones para fortalecer la economía social en sus procesos administrativos, productivos, económicos, financieros y de intercambio de bienes y servicios; ajustados siempre a parámetros de identidad, valores y principios fundamentales que rigen la ética social.
6	1	2	Su principal mercado laboral se encuentra en empresas dedicadas a la producción de bienes y a la prestación de servicios; engloba las tareas de planificación, gestión, seguimiento, control y mejora continua de materiales, componentes y productos terminados desde los proveedores hasta los consumidores.
7	8	1	El Educador o la Educadora en Educación Especial participa de manera permanente en procesos multidimensionales relacionados con la formación integral, aprovechando experiencias formales y no formales que le permitan preservar el ambiente y conservar la salud física, mental y social en sí mismo y en sus educandos con necesidades educativas especiales, asociadas o no a discapacidad permanente o transitoria, en contextos diversos.
8	7	1	El egresado o la egresada del Programa Nacional de Formación en Educación Inicial posee una sólida formación transdisciplinaria acorde con las exigencias del país, con enfoque crítico, ecológico y de carácter preventivo, éticamente comprometido o comprometida. Su alto sentido de servicio y fortaleza sociocultural están fundamentados en saberes teóricos, metodológicos, prácticos y técnicos, en correspondencia con las innovaciones y tendencias educativas en el nivel.
9	9	1	Los egresados y las egresadas del Programa Nacional de Formación en Ingeniería Agroalimentaria investigan la evolución y métodos para obtener productos aptos para el consumo humano, así como también los efectos químicos, biológicos y físicos que intervienen en la obtención y conservación de los mismos. Se ocupan del desarrollo operativo en lo que se refiere al cultivo y cría, reajustes para el consumo, asignación y uso de los productos, cuidando la cultura campesina de la región en servicio de la colectividad.
10	9	2	Su principal mercado laboral se encuentra en industrias de elaboración, preservación y pueden desempeñar su actividad profesional en laboratorios de alimentación, empresas de fabricación, conservación y entrega de alimentos, industrias agroalimentarias, departamentos ligados con la química, biología, sanidad y medio ambiente, así como en la Administración Pública.
11	4	1	Los egresados y las egresadas del Programa Nacional de Formación en Informática son profesionales con formación integral que se desempeñan con idoneidad y ética profesional en la conceptualización y construcción de productos tecnológicos informáticos en armonía con la preservación del ambiente y del progreso de su entorno, aplicando los saberes para: participar en la administración de proyectos informáticos bajo estándares de calidad y pertinencia social; auditar sistemas informáticos; desarrollar e implantar software bajo estándares de calidad y pertinencia social, priorizando el uso de plataformas libres; integrar y optimizar sistemas informáticos; diseñar, implementar y administrar bases de datos y redes informáticas bajo estándares de calidad, priorizando el uso de software libre.
12	2	1	El egresado o la egresada del Programa Nacional de Formación en Trabajo Social poseen una sólida formación transdisciplinaria con enfoque crítico y carácter preventivo, éticamente comprometida/o, con alto sentido de servicio y fortaleza ética, fundamentada en el área del conocer por saberes teóricos, prácticos, metodológicos y técnicos que le permiten en su accionar profesional organizar, planificar, orientar, evaluar, dirigir e investigar con base científica, social, metodológica y técnica, los procesos orientados en el hacer a la atención integral e integradora de la población vulnerable en espacios convencionales y no convencionales.
13	2	2	Forma parte de los equipos interdisciplinarios e intersectoriales de acción, dirigidos a la atención de las personas, las familias y la comunidad, conscientes de su labor como protagonistas, promotores e innovadores en la sociedad a la que pertenecen, en un continuo pedagógico, creativo, dinámico, reflexivo de su praxis. Se ocupan de su desarrollo personal y profesional desde la producción intelectual, pluricultural, multiétnica, democrática y respetuosa de la diversidad.
14	5	1	Los egresados y las egresadas del Programa Nacional de Formación en Turismo son ciudadanos de formación integral con identidad nacional y principios socio-humanistas, integrados a la diversidad cultural, críticos, creativos, proactivos, bilingües y comunitarios, con vocación al servicio. Están formados y formadas para el emprendimiento, la investigación, la gestión de políticas y proyectos en comunidades, unidades de producción y prestación de servicios turísticos.
15	5	2	Administran de manera responsable, eficiente y eficaz el talento humano, los recursos financieros, económicos y el patrimonio nacional en favor de la comunidad, de los turistas y visitantes. Ejecutan los procesos de promoción y comercialización de los mismos, influyendo positivamente en el desarrollo turístico endógeno, de manera sustentable y sostenible.
\.


--
-- Data for Name: carrera_turnos; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.carrera_turnos (id, carrera_id, turno) FROM stdin;
2	3	Tarde (Excepto en el N£cleo Altagracia)
3	3	Noche
4	6	Tarde
5	6	Noche
7	1	Tarde
8	1	Noche
10	8	Tarde
11	8	Noche
13	7	Tarde
16	4	Tarde
17	4	Noche
19	2	Tarde
20	2	Noche
22	5	Tarde
23	5	Noche
1	3	Mañana
6	1	Mañana
9	8	Mañana
12	7	Mañana
14	9	Mañana
15	4	Mañana
18	2	Mañana
21	5	Mañana
\.


--
-- Data for Name: contactos_coordinadores_pnf; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.contactos_coordinadores_pnf (id, nombre_completo, titulo_academico, telefono, email, oficina, horario_atencion, nucleo_id, carrera_id) FROM stdin;
1	Andrys Andreina Danielle Mendoza	\N	0424-5219302	adrys.planificacion@gmail.com	Edificio Mercurio, Planta, Zona Industrial de la Urbina c/8	\N	3	3
2	Marisol Ram¡rez	Msc.	0412-5829696	cpnfcpunexca@gmail.com	N£cleo Altagracia. Piso 3.	Mi‚rcoles a viernes de 9:00 am a 12:00 pm	1	6
3	Omar Serrano	Lic.	0412-5304042	omarser4@gmail.com	N£cleo Altagracia	Lunes, martes y mi‚rcoles de 1:00 pm a 5:00 pm	1	1
4	Gloria Malav‚	Msc.	0414-9209238	gloriamalave1@hotmail.com	N£cleo La Urbina, piso 3	\N	3	1
5	Yenni Saavedra	\N	0412-2340136	unexca2022@gmail.com	\N	\N	\N	8
7	Belkis Hern ndez	Prof.	0426-2468940 / 0412-6133078	coordinacionpnfts.unexca@gmail.com	N£cleo Altagracia, piso 3, oficina 14	Lunes a viernes de 8:30 am a 12:30 m y de 5:00 a 7:30 pm	1	2
8	Gina B ez Lander	\N	0424-1412083	coorturismo21@gmail.com	N£cleo La Urbina, piso 3	Lunes a viernes 9:00 am-4:00 pm	3	5
9	Magaly Macho	\N	\N	\N	N£cleo La Floresta, piso 5	Lunes a viernes 9:00 am-4:00 pm	2	5
10	Magaly Macho	\N	\N	\N	N£cleo La Guaira, Catia La Mar	\N	4	5
6	Enrique Moreno	\N	0412-3759490	\N	Núcleo La Floresta	Lunes a viernes de 8:00 am a 03:00 pm	2	4
\.


--
-- Data for Name: contactos_directivos; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.contactos_directivos (id, nombre_completo, cargo, telefono, email, oficina, nucleo_id) FROM stdin;
1	Dr. Marta µvila D vila	Directora del N£cleo Altagracia	0416-6184213	direccionnucleoaltagracia@gmail.com	\N	1
2	Msc. William Leal	Coordinador de Planificaci¢n acad‚mica	0412-3128954	direccionnucleoaltagracia@gmail.com	\N	1
3	Msc. Mar¡a Blanco	Directora del N£cleo La Floresta	0416-6086356	direccionnucleolafloresta27@gmail.com	\N	2
4	Desconocido	Coordinador de Planificaci¢n acad‚mica	0414-1214194	direccionnucleolafloresta27@gmail.com	\N	2
5	Roberto Rodr¡guez	Coordinador de Seguimiento y Evaluaci¢n	0412-5840987	direccionnucleolafloresta27@gmail.com	\N	2
6	Desconocido	Coordinador de Proyecto	0414-1214194	direccionnucleolafloresta27@gmail.com	\N	2
7	Esp. Eneida Arreaza	Directora del N£cleo La Urbina	\N	Evais1975@hotmail.com	\N	3
8	Prof. Eleazar Aguiar	Coordinador de Proyecto	0416-0126159	eaguiar5@hotmail.com	\N	3
9	Dr. Beatriz Le¢n de µlvarez	Coordinadora de Planificaci¢n	0424-5219302	andrys.planificacion@gmail.com	Edificio Mercurio, Planta, Zona Industrial de la Urbina c/8.	3
\.


--
-- Data for Name: faqs; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.faqs (id, pregunta, respuesta) FROM stdin;
1	¿Cómo descargar la malla curricular?	La malla curricular se puede descargar a través del Instagram oficial de la UNEXCA.
2	¿Qué significa PNF?	Las siglas significan Programa Nacional de Formación. Se trata de un programa académico que ofrece formación profesional en diferentes áreas del conocimiento.
3	¿Cómo puedo unirme a comunidades y organizaciones estudiantiles?	En nuestra misma página web, al final de ella se encuentran los íconos de redes sociales de la UNEXCA, para que de esta manera puedas unirte a nuestras comunidades y organizaciones estudiantiles.
4	¿Cómo puedo saber de eventos sociales y culturales que se organicen en la universidad?	Cuando te encuentres en la página en el apartado de noticias encontrado en la parte de arriba, ahí podrás ver los eventos sociales y culturales, y muchas más noticias actualizadas que sean de tu interés.
5	¿Cómo puedo reportar un problema técnico?	El correo Cesolicitudes.unexca@gmail.com, es exclusivamente para solicitudes o algo que se requiera, si necesita información puede indagar las redes sociales oficiales de la UNEXCA, si busca alguna información en particular dirigirse a su núcleo correspondiente.
6	¿Qué oportunidades de prácticas o pasantías existen?	Nuestra casa se estudio UNEXCA está asociada con PDVSA, para los estudiantes que requiera pasantías con su proyecto.
7	¿Ofrecen programas de maestría y doctorado?	Ofrecemos doctorados en RRHH y otro en auditoria de calidad del dato financiero.
8	¿Se ofrecen talleres de habilidades académicas?	Si, en el Telegram de cada núcleo constantemente se publica ofertas de cursos de varios tipos, los más frecuentes se hacen en el SIGMA e Mencyt.
9	¿Qué tipo de bibliotecas y recursos de investigación tienen?	Si nos dirigimos al link debajo de la descripción del Instagram oficial de la UNEXCA encontraremos un bloque de descarga de libros, los cuales sirven como material de estudio.
\.


--
-- Data for Name: menu_enlaces_dinamicos; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.menu_enlaces_dinamicos (id, menu_id, titulo, url, tabla_origen, registro_id, padre_id, orden) FROM stdin;
2	1	Trabajo Social	trabajo-social	carrera	2	2	2
5	1	Turismo	turismo	carrera	5	2	5
1	1	Distribución y Logística	distribucion-y-logistica	carrera	1	2	1
3	1	Administración	administracion	carrera	3	2	3
4	1	Ing. Informática	ing-informatica	carrera	4	2	4
6	1	Contaduría	contaduria	carrera	6	2	6
7	1	Educación Inicial	educacion-inicial	carrera	7	2	7
8	1	Educación Especial	educacion-especial	carrera	8	2	8
9	1	Ing. Agroalimentaria	ing-agroalimentaria	carrera	9	2	9
\.


--
-- Data for Name: menu_enlaces_estaticos; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.menu_enlaces_estaticos (id, menu_id, titulo, url, padre_id, orden) FROM stdin;
5	1	Misión, Visión y Valores	mision-vision-valores	3	3
6	1	Autoridades Universitarias	autoridades	3	4
7	1	Historia	historia	3	2
9	1	Preguntas Frecuentes	faqs	4	10
10	1	Servicios	servicios	4	8
8	1	Contactos	contactos	4	9
2	1	Programas Académicos	\N	\N	5
3	1	La Unexca	\N	\N	1
4	1	Acerca de...	\N	\N	7
\.


--
-- Data for Name: menus; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.menus (id, nombre, descripcion) FROM stdin;
1	Header	Menú principal de la parte superior del sitio web
2	Footer	Enlaces en el pie de pagina.
\.


--
-- Data for Name: noticias; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.noticias (noticia_id, titulo_principal, descripcion_corta, imagen_principal, descripcion_imagen, url, fecha_creacion, fecha_publicacion, fecha_modificacion) FROM stdin;
\.


--
-- Data for Name: noticias_contenido; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.noticias_contenido (contenido_id, noticia_id, tipo_bloque, datos, posicion) FROM stdin;
\.


--
-- Data for Name: nucleos; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.nucleos (id, nombre) FROM stdin;
1	Altagracia
2	La Floresta
3	La Urbina
4	La Guaira
\.


--
-- Data for Name: servicios; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.servicios (id, servicio, respuesta) FROM stdin;
10	Cambio de núcleo	Cualquier estudiante de la UNEXCA puede solicitar un cambio de núcleo al cumplir con los requisitos mínimos. Este trámite estará disponible una vez al año y la fecha serán publicadas en el Calendario Académico UNEXCA y los canales oficiales de información de la universidad.
11	Cambio de PNF	Cualquier estudiante de la UNEXCA puede solicitar un cambio de Programa Nacional de Formación, si así lo desea. Deberá cumplir una serie de requisitos que solicitará en la oficina de Control de estudios.\n\nEste trámite estará disponible una vez al año y la fecha serán publicadas en el Calendario Académico UNEXCA y los canales oficiales de información de la universidad.\n\nImportante: El estudiante debe traer el comprobante de recibido que se le entregó al momento de realizar la solicitud, junto a una copia de su cédula de identidad, para realizar cualquier verificación o corrección al listado publicado.
12	Cambio de turno	Cualquier estudiante de la UNEXCA puede solicitar un cambio de turno al cumplir con los requisitos mínimos. Este trámite estará disponible una vez al año y la fecha serán publicadas en el Calendario Académico UNEXCA y los canales oficiales de información de la universidad.\n\nImportante: El estudiante debe traer el comprobante de recibido que se le entregó al momento de realizar la solicitud, junto a una copia de su cédula de identidad, para realizar cualquier verificación o corrección al listado publicado.
13	Convocatoria al Acto de Grado	La convocatoria al Acto de Grado se publicará en los canales oficiales de información de la UNEXCA, y en las carteleras de Control de Estudios de cada núcleo.\n\nEn el listado solo aparecerán aquellos estudiantes que hayan realizado satisfactoriamente las solicitudes de Conferimiento y Verificación de expedientes.
14	Materias pendientes	Cualquier estudiante de la UNEXCA puede solicitar un récord de materias pendientes por aprobar para optar por el título. Esta solicitud se hace a través de la Coordinación de PNF de cada núcleo.\n\nSi el estudiante está registrado por SGA lo hace a través del sistema; si es manual, debe ser con la Coordinación del PNF correspondiente. Solo podrá hacerlo al haber terminado el trayecto.
15	Reingresos	Las y los estudiantes de la UNEXCA que hayan retirado su período académico podrán solicitar su reingreso como estudiantes regulares.\n\nEste trámite estará disponible una vez al año y la fecha serán publicadas en el Calendario Académico UNEXCA y los canales oficiales de información de la universidad.
16	Solicitud de Conferimiento	La solicitud de Conferimiento para optar al Acto de Grado se realiza a través del Sistema de Gestión Académica de la UNEXCA.\n\nLos estudiantes deben entregar en las oficinas de Control de Estudios los requisitos en la fecha en que esté abierta la convocatoria.\n\nVerificación de Expedientes: Es un paso vinculado a la Solicitud de Conferimiento, en el que se validan todos los documentos entregados, su veracidad, registro y origen.
17	Solicitud de notas	Cualquier estudiante puede hacer la solicitud de sus notas directamente en la oficina de Control de estudios de su núcleo.
18	Solicitud de unidades curriculares pendientes	Para la solicitud de unidades curriculares pendientes existen dos procedimientos:\n\nPrimero: Si el estudiante es de último semestre y está en espera de su acto de grado debe dirigirse al final del semestre con una carta y oferta de la unidad curricular pendiente que requiera o elija ver, y llevarla a la coordinación de la carrera que le corresponda.\n\nSegundo: Si el estudiante está en algún semestre que no sea el último, debe esperar al semestre de verano (CIU) que realiza la universidad y ellos ofertan las unidades curriculares disponibles y los estudiantes deben anotarse en una lista en control de estudios.
\.


--
-- Name: autoridades_academicas_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.autoridades_academicas_id_seq', 8, true);


--
-- Name: carrera_niveles_academicos_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.carrera_niveles_academicos_id_seq', 16, true);


--
-- Name: carrera_nucleos_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.carrera_nucleos_id_seq', 24, true);


--
-- Name: carrera_parrafos_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.carrera_parrafos_id_seq', 15, true);


--
-- Name: carrera_turnos_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.carrera_turnos_id_seq', 23, true);


--
-- Name: carreras_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.carreras_id_seq', 9, true);


--
-- Name: contactos_coordinadores_pnf_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.contactos_coordinadores_pnf_id_seq', 10, true);


--
-- Name: contactos_directivos_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.contactos_directivos_id_seq', 9, true);


--
-- Name: faqs_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.faqs_id_seq', 9, true);


--
-- Name: menu_enlaces_dinamicos_id_seq1; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.menu_enlaces_dinamicos_id_seq1', 1, false);


--
-- Name: menu_enlaces_estaticos_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.menu_enlaces_estaticos_id_seq', 10, true);


--
-- Name: menus_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.menus_id_seq', 2, true);


--
-- Name: noticias_contenido_contenido_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.noticias_contenido_contenido_id_seq', 1, false);


--
-- Name: noticias_noticia_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.noticias_noticia_id_seq', 1, false);


--
-- Name: nucleos_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.nucleos_id_seq', 4, true);


--
-- Name: servicios_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.servicios_id_seq', 18, true);


--
-- Name: autoridades_academicas autoridades_academicas_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.autoridades_academicas
    ADD CONSTRAINT autoridades_academicas_pkey PRIMARY KEY (id);


--
-- Name: carrera_niveles_academicos carrera_niveles_academicos_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.carrera_niveles_academicos
    ADD CONSTRAINT carrera_niveles_academicos_pkey PRIMARY KEY (id);


--
-- Name: carrera_nucleos carrera_nucleos_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.carrera_nucleos
    ADD CONSTRAINT carrera_nucleos_pkey PRIMARY KEY (id);


--
-- Name: carrera_parrafos carrera_parrafos_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.carrera_parrafos
    ADD CONSTRAINT carrera_parrafos_pkey PRIMARY KEY (id);


--
-- Name: carrera carrera_slug_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.carrera
    ADD CONSTRAINT carrera_slug_key UNIQUE (slug);


--
-- Name: carrera_turnos carrera_turnos_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.carrera_turnos
    ADD CONSTRAINT carrera_turnos_pkey PRIMARY KEY (id);


--
-- Name: carrera carreras_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.carrera
    ADD CONSTRAINT carreras_pkey PRIMARY KEY (id);


--
-- Name: contactos_coordinadores_pnf contactos_coordinadores_pnf_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.contactos_coordinadores_pnf
    ADD CONSTRAINT contactos_coordinadores_pnf_pkey PRIMARY KEY (id);


--
-- Name: contactos_directivos contactos_directivos_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.contactos_directivos
    ADD CONSTRAINT contactos_directivos_pkey PRIMARY KEY (id);


--
-- Name: faqs faqs_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.faqs
    ADD CONSTRAINT faqs_pkey PRIMARY KEY (id);


--
-- Name: menu_enlaces_dinamicos menu_enlaces_dinamicos_pkey1; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.menu_enlaces_dinamicos
    ADD CONSTRAINT menu_enlaces_dinamicos_pkey1 PRIMARY KEY (id);


--
-- Name: menu_enlaces_estaticos menu_enlaces_estaticos_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.menu_enlaces_estaticos
    ADD CONSTRAINT menu_enlaces_estaticos_pkey PRIMARY KEY (id);


--
-- Name: menus menus_nombre_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.menus
    ADD CONSTRAINT menus_nombre_key UNIQUE (nombre);


--
-- Name: menus menus_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.menus
    ADD CONSTRAINT menus_pkey PRIMARY KEY (id);


--
-- Name: noticias_contenido noticias_contenido_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.noticias_contenido
    ADD CONSTRAINT noticias_contenido_pkey PRIMARY KEY (contenido_id);


--
-- Name: noticias noticias_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.noticias
    ADD CONSTRAINT noticias_pkey PRIMARY KEY (noticia_id);


--
-- Name: noticias noticias_url_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.noticias
    ADD CONSTRAINT noticias_url_key UNIQUE (url);


--
-- Name: nucleos nucleos_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.nucleos
    ADD CONSTRAINT nucleos_pkey PRIMARY KEY (id);


--
-- Name: servicios servicios_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.servicios
    ADD CONSTRAINT servicios_pkey PRIMARY KEY (id);


--
-- Name: carrera_niveles_academicos carrera_niveles_academicos_carrera_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.carrera_niveles_academicos
    ADD CONSTRAINT carrera_niveles_academicos_carrera_id_fkey FOREIGN KEY (carrera_id) REFERENCES public.carrera(id) ON DELETE CASCADE;


--
-- Name: carrera_nucleos carrera_nucleos_carrera_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.carrera_nucleos
    ADD CONSTRAINT carrera_nucleos_carrera_id_fkey FOREIGN KEY (carrera_id) REFERENCES public.carrera(id) ON DELETE CASCADE;


--
-- Name: carrera_nucleos carrera_nucleos_nucleo_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.carrera_nucleos
    ADD CONSTRAINT carrera_nucleos_nucleo_id_fkey FOREIGN KEY (nucleo_id) REFERENCES public.nucleos(id) ON DELETE CASCADE;


--
-- Name: carrera_parrafos carrera_parrafos_carrera_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.carrera_parrafos
    ADD CONSTRAINT carrera_parrafos_carrera_id_fkey FOREIGN KEY (carrera_id) REFERENCES public.carrera(id) ON DELETE CASCADE;


--
-- Name: carrera_turnos carrera_turnos_carrera_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.carrera_turnos
    ADD CONSTRAINT carrera_turnos_carrera_id_fkey FOREIGN KEY (carrera_id) REFERENCES public.carrera(id) ON DELETE CASCADE;


--
-- Name: contactos_coordinadores_pnf contactos_coordinadores_pnf_carrera_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.contactos_coordinadores_pnf
    ADD CONSTRAINT contactos_coordinadores_pnf_carrera_id_fkey FOREIGN KEY (carrera_id) REFERENCES public.carrera(id) ON DELETE CASCADE;


--
-- Name: contactos_coordinadores_pnf contactos_coordinadores_pnf_nucleo_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.contactos_coordinadores_pnf
    ADD CONSTRAINT contactos_coordinadores_pnf_nucleo_id_fkey FOREIGN KEY (nucleo_id) REFERENCES public.nucleos(id) ON DELETE SET NULL;


--
-- Name: contactos_directivos contactos_directivos_nucleo_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.contactos_directivos
    ADD CONSTRAINT contactos_directivos_nucleo_id_fkey FOREIGN KEY (nucleo_id) REFERENCES public.nucleos(id) ON DELETE CASCADE;


--
-- Name: menu_enlaces_dinamicos menu_enlaces_dinamicos_menu_id_fkey1; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.menu_enlaces_dinamicos
    ADD CONSTRAINT menu_enlaces_dinamicos_menu_id_fkey1 FOREIGN KEY (menu_id) REFERENCES public.menus(id) ON DELETE CASCADE;


--
-- Name: menu_enlaces_dinamicos menu_enlaces_dinamicos_padre_id_fkey1; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.menu_enlaces_dinamicos
    ADD CONSTRAINT menu_enlaces_dinamicos_padre_id_fkey1 FOREIGN KEY (padre_id) REFERENCES public.menu_enlaces_estaticos(id) ON DELETE CASCADE;


--
-- Name: menu_enlaces_estaticos menu_enlaces_estaticos_menu_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.menu_enlaces_estaticos
    ADD CONSTRAINT menu_enlaces_estaticos_menu_id_fkey FOREIGN KEY (menu_id) REFERENCES public.menus(id) ON DELETE CASCADE;


--
-- Name: menu_enlaces_estaticos menu_enlaces_estaticos_padre_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.menu_enlaces_estaticos
    ADD CONSTRAINT menu_enlaces_estaticos_padre_id_fkey FOREIGN KEY (padre_id) REFERENCES public.menu_enlaces_estaticos(id) ON DELETE CASCADE;


--
-- Name: noticias_contenido noticias_contenido_noticia_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.noticias_contenido
    ADD CONSTRAINT noticias_contenido_noticia_id_fkey FOREIGN KEY (noticia_id) REFERENCES public.noticias(noticia_id) ON DELETE CASCADE;


--
-- PostgreSQL database dump complete
--

\unrestrict 8zYqThvCjtnb2MNbpvgGwhc1mdBPv8Vor5QacjZ33VBgdDpLDcyoz658isOkAqn

