--
-- PostgreSQL database dump
--

-- Dumped from database version 17.5 (Debian 17.5-1.pgdg120+1)
-- Dumped by pg_dump version 17.5 (Debian 17.5-1.pgdg120+1)

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

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- Name: affectations; Type: TABLE; Schema: public; Owner: sail
--

CREATE TABLE public.affectations (
    id_affectation bigint NOT NULL,
    id_utilisateur bigint NOT NULL,
    id_role bigint NOT NULL,
    affectable_type character varying(255) NOT NULL,
    affectable_id bigint NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.affectations OWNER TO sail;

--
-- Name: affectations_id_affectation_seq; Type: SEQUENCE; Schema: public; Owner: sail
--

CREATE SEQUENCE public.affectations_id_affectation_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.affectations_id_affectation_seq OWNER TO sail;

--
-- Name: affectations_id_affectation_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: sail
--

ALTER SEQUENCE public.affectations_id_affectation_seq OWNED BY public.affectations.id_affectation;


--
-- Name: cache; Type: TABLE; Schema: public; Owner: sail
--

CREATE TABLE public.cache (
    key character varying(255) NOT NULL,
    value text NOT NULL,
    expiration integer NOT NULL
);


ALTER TABLE public.cache OWNER TO sail;

--
-- Name: cache_locks; Type: TABLE; Schema: public; Owner: sail
--

CREATE TABLE public.cache_locks (
    key character varying(255) NOT NULL,
    owner character varying(255) NOT NULL,
    expiration integer NOT NULL
);


ALTER TABLE public.cache_locks OWNER TO sail;

--
-- Name: coproprietes; Type: TABLE; Schema: public; Owner: sail
--

CREATE TABLE public.coproprietes (
    id_copropriete bigint NOT NULL,
    id_syndic bigint NOT NULL,
    nom_copropriete character varying(255) NOT NULL,
    statut boolean DEFAULT true NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.coproprietes OWNER TO sail;

--
-- Name: coproprietes_id_copropriete_seq; Type: SEQUENCE; Schema: public; Owner: sail
--

CREATE SEQUENCE public.coproprietes_id_copropriete_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.coproprietes_id_copropriete_seq OWNER TO sail;

--
-- Name: coproprietes_id_copropriete_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: sail
--

ALTER SEQUENCE public.coproprietes_id_copropriete_seq OWNED BY public.coproprietes.id_copropriete;


--
-- Name: failed_jobs; Type: TABLE; Schema: public; Owner: sail
--

CREATE TABLE public.failed_jobs (
    id bigint NOT NULL,
    uuid character varying(255) NOT NULL,
    connection text NOT NULL,
    queue text NOT NULL,
    payload text NOT NULL,
    exception text NOT NULL,
    failed_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL
);


ALTER TABLE public.failed_jobs OWNER TO sail;

--
-- Name: failed_jobs_id_seq; Type: SEQUENCE; Schema: public; Owner: sail
--

CREATE SEQUENCE public.failed_jobs_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.failed_jobs_id_seq OWNER TO sail;

--
-- Name: failed_jobs_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: sail
--

ALTER SEQUENCE public.failed_jobs_id_seq OWNED BY public.failed_jobs.id;


--
-- Name: job_batches; Type: TABLE; Schema: public; Owner: sail
--

CREATE TABLE public.job_batches (
    id character varying(255) NOT NULL,
    name character varying(255) NOT NULL,
    total_jobs integer NOT NULL,
    pending_jobs integer NOT NULL,
    failed_jobs integer NOT NULL,
    failed_job_ids text NOT NULL,
    options text,
    cancelled_at integer,
    created_at integer NOT NULL,
    finished_at integer
);


ALTER TABLE public.job_batches OWNER TO sail;

--
-- Name: jobs; Type: TABLE; Schema: public; Owner: sail
--

CREATE TABLE public.jobs (
    id bigint NOT NULL,
    queue character varying(255) NOT NULL,
    payload text NOT NULL,
    attempts smallint NOT NULL,
    reserved_at integer,
    available_at integer NOT NULL,
    created_at integer NOT NULL
);


ALTER TABLE public.jobs OWNER TO sail;

--
-- Name: jobs_id_seq; Type: SEQUENCE; Schema: public; Owner: sail
--

CREATE SEQUENCE public.jobs_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.jobs_id_seq OWNER TO sail;

--
-- Name: jobs_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: sail
--

ALTER SEQUENCE public.jobs_id_seq OWNED BY public.jobs.id;


--
-- Name: langues; Type: TABLE; Schema: public; Owner: sail
--

CREATE TABLE public.langues (
    id_langue bigint NOT NULL,
    code_langue character varying(5) NOT NULL,
    nom character varying(255) NOT NULL,
    est_active boolean DEFAULT true NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.langues OWNER TO sail;

--
-- Name: langues_id_langue_seq; Type: SEQUENCE; Schema: public; Owner: sail
--

CREATE SEQUENCE public.langues_id_langue_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.langues_id_langue_seq OWNER TO sail;

--
-- Name: langues_id_langue_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: sail
--

ALTER SEQUENCE public.langues_id_langue_seq OWNED BY public.langues.id_langue;


--
-- Name: lot_proprietaire; Type: TABLE; Schema: public; Owner: sail
--

CREATE TABLE public.lot_proprietaire (
    id_lot bigint NOT NULL,
    id_proprietaire bigint NOT NULL,
    pourcentage_possession numeric(5,2) DEFAULT '100'::numeric NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.lot_proprietaire OWNER TO sail;

--
-- Name: lots; Type: TABLE; Schema: public; Owner: sail
--

CREATE TABLE public.lots (
    id_lot bigint NOT NULL,
    id_residence bigint NOT NULL,
    numero_lot character varying(255) NOT NULL,
    nombre_tantiemes integer DEFAULT 0 NOT NULL,
    statut boolean DEFAULT true NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.lots OWNER TO sail;

--
-- Name: lots_id_lot_seq; Type: SEQUENCE; Schema: public; Owner: sail
--

CREATE SEQUENCE public.lots_id_lot_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.lots_id_lot_seq OWNER TO sail;

--
-- Name: lots_id_lot_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: sail
--

ALTER SEQUENCE public.lots_id_lot_seq OWNED BY public.lots.id_lot;


--
-- Name: migrations; Type: TABLE; Schema: public; Owner: sail
--

CREATE TABLE public.migrations (
    id integer NOT NULL,
    migration character varying(255) NOT NULL,
    batch integer NOT NULL
);


ALTER TABLE public.migrations OWNER TO sail;

--
-- Name: migrations_id_seq; Type: SEQUENCE; Schema: public; Owner: sail
--

CREATE SEQUENCE public.migrations_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.migrations_id_seq OWNER TO sail;

--
-- Name: migrations_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: sail
--

ALTER SEQUENCE public.migrations_id_seq OWNED BY public.migrations.id;


--
-- Name: password_reset_tokens; Type: TABLE; Schema: public; Owner: sail
--

CREATE TABLE public.password_reset_tokens (
    email character varying(255) NOT NULL,
    token character varying(255) NOT NULL,
    created_at timestamp(0) without time zone
);


ALTER TABLE public.password_reset_tokens OWNER TO sail;

--
-- Name: permissions; Type: TABLE; Schema: public; Owner: sail
--

CREATE TABLE public.permissions (
    id_permission bigint NOT NULL,
    cle character varying(255) NOT NULL,
    nom_permission json NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.permissions OWNER TO sail;

--
-- Name: permissions_id_permission_seq; Type: SEQUENCE; Schema: public; Owner: sail
--

CREATE SEQUENCE public.permissions_id_permission_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.permissions_id_permission_seq OWNER TO sail;

--
-- Name: permissions_id_permission_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: sail
--

ALTER SEQUENCE public.permissions_id_permission_seq OWNED BY public.permissions.id_permission;


--
-- Name: proprietaires; Type: TABLE; Schema: public; Owner: sail
--

CREATE TABLE public.proprietaires (
    id_proprietaire bigint NOT NULL,
    id_utilisateur bigint,
    type_proprietaire character varying(255) DEFAULT 'personne_physique'::character varying NOT NULL,
    nom character varying(255) NOT NULL,
    email character varying(255),
    telephone_contact character varying(255),
    adresse_postale character varying(255),
    code_postal character varying(10),
    ville character varying(255),
    pays character varying(255),
    civilite character varying(255),
    prenom character varying(255),
    date_naissance date,
    forme_juridique character varying(255),
    numero_siret character varying(255),
    iban character varying(255),
    bic character varying(255),
    commentaires text,
    statut boolean DEFAULT true NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.proprietaires OWNER TO sail;

--
-- Name: proprietaires_id_proprietaire_seq; Type: SEQUENCE; Schema: public; Owner: sail
--

CREATE SEQUENCE public.proprietaires_id_proprietaire_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.proprietaires_id_proprietaire_seq OWNER TO sail;

--
-- Name: proprietaires_id_proprietaire_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: sail
--

ALTER SEQUENCE public.proprietaires_id_proprietaire_seq OWNED BY public.proprietaires.id_proprietaire;


--
-- Name: residences; Type: TABLE; Schema: public; Owner: sail
--

CREATE TABLE public.residences (
    id_residence bigint NOT NULL,
    id_copropriete bigint NOT NULL,
    nom_residence character varying(255) NOT NULL,
    adresse character varying(255),
    code_postal character varying(10),
    ville character varying(255),
    statut boolean DEFAULT true NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.residences OWNER TO sail;

--
-- Name: residences_id_residence_seq; Type: SEQUENCE; Schema: public; Owner: sail
--

CREATE SEQUENCE public.residences_id_residence_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.residences_id_residence_seq OWNER TO sail;

--
-- Name: residences_id_residence_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: sail
--

ALTER SEQUENCE public.residences_id_residence_seq OWNED BY public.residences.id_residence;


--
-- Name: role_has_permission; Type: TABLE; Schema: public; Owner: sail
--

CREATE TABLE public.role_has_permission (
    id_role bigint NOT NULL,
    id_permission bigint NOT NULL
);


ALTER TABLE public.role_has_permission OWNER TO sail;

--
-- Name: roles; Type: TABLE; Schema: public; Owner: sail
--

CREATE TABLE public.roles (
    id_role bigint NOT NULL,
    nom_role json NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.roles OWNER TO sail;

--
-- Name: roles_id_role_seq; Type: SEQUENCE; Schema: public; Owner: sail
--

CREATE SEQUENCE public.roles_id_role_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.roles_id_role_seq OWNER TO sail;

--
-- Name: roles_id_role_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: sail
--

ALTER SEQUENCE public.roles_id_role_seq OWNED BY public.roles.id_role;


--
-- Name: sessions; Type: TABLE; Schema: public; Owner: sail
--

CREATE TABLE public.sessions (
    id character varying(255) NOT NULL,
    user_id bigint,
    ip_address character varying(45),
    user_agent text,
    payload text NOT NULL,
    last_activity integer NOT NULL
);


ALTER TABLE public.sessions OWNER TO sail;

--
-- Name: syndics; Type: TABLE; Schema: public; Owner: sail
--

CREATE TABLE public.syndics (
    id_syndic bigint NOT NULL,
    nom_entreprise character varying(255) NOT NULL,
    statut boolean DEFAULT true NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.syndics OWNER TO sail;

--
-- Name: syndics_id_syndic_seq; Type: SEQUENCE; Schema: public; Owner: sail
--

CREATE SEQUENCE public.syndics_id_syndic_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.syndics_id_syndic_seq OWNER TO sail;

--
-- Name: syndics_id_syndic_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: sail
--

ALTER SEQUENCE public.syndics_id_syndic_seq OWNED BY public.syndics.id_syndic;


--
-- Name: users; Type: TABLE; Schema: public; Owner: sail
--

CREATE TABLE public.users (
    id bigint NOT NULL,
    name character varying(255) NOT NULL,
    email character varying(255) NOT NULL,
    email_verified_at timestamp(0) without time zone,
    password character varying(255) NOT NULL,
    remember_token character varying(100),
    is_super_admin boolean DEFAULT false NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    id_langue_preferee bigint
);


ALTER TABLE public.users OWNER TO sail;

--
-- Name: users_id_seq; Type: SEQUENCE; Schema: public; Owner: sail
--

CREATE SEQUENCE public.users_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.users_id_seq OWNER TO sail;

--
-- Name: users_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: sail
--

ALTER SEQUENCE public.users_id_seq OWNED BY public.users.id;


--
-- Name: utilisateur_role; Type: TABLE; Schema: public; Owner: sail
--

CREATE TABLE public.utilisateur_role (
    user_id bigint NOT NULL,
    id_role bigint NOT NULL
);


ALTER TABLE public.utilisateur_role OWNER TO sail;

--
-- Name: affectations id_affectation; Type: DEFAULT; Schema: public; Owner: sail
--

ALTER TABLE ONLY public.affectations ALTER COLUMN id_affectation SET DEFAULT nextval('public.affectations_id_affectation_seq'::regclass);


--
-- Name: coproprietes id_copropriete; Type: DEFAULT; Schema: public; Owner: sail
--

ALTER TABLE ONLY public.coproprietes ALTER COLUMN id_copropriete SET DEFAULT nextval('public.coproprietes_id_copropriete_seq'::regclass);


--
-- Name: failed_jobs id; Type: DEFAULT; Schema: public; Owner: sail
--

ALTER TABLE ONLY public.failed_jobs ALTER COLUMN id SET DEFAULT nextval('public.failed_jobs_id_seq'::regclass);


--
-- Name: jobs id; Type: DEFAULT; Schema: public; Owner: sail
--

ALTER TABLE ONLY public.jobs ALTER COLUMN id SET DEFAULT nextval('public.jobs_id_seq'::regclass);


--
-- Name: langues id_langue; Type: DEFAULT; Schema: public; Owner: sail
--

ALTER TABLE ONLY public.langues ALTER COLUMN id_langue SET DEFAULT nextval('public.langues_id_langue_seq'::regclass);


--
-- Name: lots id_lot; Type: DEFAULT; Schema: public; Owner: sail
--

ALTER TABLE ONLY public.lots ALTER COLUMN id_lot SET DEFAULT nextval('public.lots_id_lot_seq'::regclass);


--
-- Name: migrations id; Type: DEFAULT; Schema: public; Owner: sail
--

ALTER TABLE ONLY public.migrations ALTER COLUMN id SET DEFAULT nextval('public.migrations_id_seq'::regclass);


--
-- Name: permissions id_permission; Type: DEFAULT; Schema: public; Owner: sail
--

ALTER TABLE ONLY public.permissions ALTER COLUMN id_permission SET DEFAULT nextval('public.permissions_id_permission_seq'::regclass);


--
-- Name: proprietaires id_proprietaire; Type: DEFAULT; Schema: public; Owner: sail
--

ALTER TABLE ONLY public.proprietaires ALTER COLUMN id_proprietaire SET DEFAULT nextval('public.proprietaires_id_proprietaire_seq'::regclass);


--
-- Name: residences id_residence; Type: DEFAULT; Schema: public; Owner: sail
--

ALTER TABLE ONLY public.residences ALTER COLUMN id_residence SET DEFAULT nextval('public.residences_id_residence_seq'::regclass);


--
-- Name: roles id_role; Type: DEFAULT; Schema: public; Owner: sail
--

ALTER TABLE ONLY public.roles ALTER COLUMN id_role SET DEFAULT nextval('public.roles_id_role_seq'::regclass);


--
-- Name: syndics id_syndic; Type: DEFAULT; Schema: public; Owner: sail
--

ALTER TABLE ONLY public.syndics ALTER COLUMN id_syndic SET DEFAULT nextval('public.syndics_id_syndic_seq'::regclass);


--
-- Name: users id; Type: DEFAULT; Schema: public; Owner: sail
--

ALTER TABLE ONLY public.users ALTER COLUMN id SET DEFAULT nextval('public.users_id_seq'::regclass);


--
-- Data for Name: affectations; Type: TABLE DATA; Schema: public; Owner: sail
--

COPY public.affectations (id_affectation, id_utilisateur, id_role, affectable_type, affectable_id, created_at, updated_at) FROM stdin;
1	3	2	App\\Models\\Copropriete	1	2025-08-02 21:29:06	2025-08-02 21:29:06
\.


--
-- Data for Name: cache; Type: TABLE DATA; Schema: public; Owner: sail
--

COPY public.cache (key, value, expiration) FROM stdin;
\.


--
-- Data for Name: cache_locks; Type: TABLE DATA; Schema: public; Owner: sail
--

COPY public.cache_locks (key, owner, expiration) FROM stdin;
\.


--
-- Data for Name: coproprietes; Type: TABLE DATA; Schema: public; Owner: sail
--

COPY public.coproprietes (id_copropriete, id_syndic, nom_copropriete, statut, created_at, updated_at) FROM stdin;
1	1	Copropriété du Grand Parc	t	2025-08-02 21:29:03	2025-08-02 21:29:03
2	2	Copropriété du Lac	t	2025-08-02 21:29:03	2025-08-02 21:29:03
\.


--
-- Data for Name: failed_jobs; Type: TABLE DATA; Schema: public; Owner: sail
--

COPY public.failed_jobs (id, uuid, connection, queue, payload, exception, failed_at) FROM stdin;
\.


--
-- Data for Name: job_batches; Type: TABLE DATA; Schema: public; Owner: sail
--

COPY public.job_batches (id, name, total_jobs, pending_jobs, failed_jobs, failed_job_ids, options, cancelled_at, created_at, finished_at) FROM stdin;
\.


--
-- Data for Name: jobs; Type: TABLE DATA; Schema: public; Owner: sail
--

COPY public.jobs (id, queue, payload, attempts, reserved_at, available_at, created_at) FROM stdin;
\.


--
-- Data for Name: langues; Type: TABLE DATA; Schema: public; Owner: sail
--

COPY public.langues (id_langue, code_langue, nom, est_active, created_at, updated_at) FROM stdin;
1	fr	Français	t	2025-08-02 21:29:02	2025-08-02 21:29:02
2	en	English	t	2025-08-02 21:29:02	2025-08-02 21:29:02
\.


--
-- Data for Name: lot_proprietaire; Type: TABLE DATA; Schema: public; Owner: sail
--

COPY public.lot_proprietaire (id_lot, id_proprietaire, pourcentage_possession, created_at, updated_at) FROM stdin;
1	1	100.00	2025-08-02 21:29:05	2025-08-02 21:29:05
2	1	100.00	2025-08-02 21:29:05	2025-08-02 21:29:05
3	2	50.00	2025-08-02 21:29:05	2025-08-02 21:29:05
3	1	50.00	2025-08-02 21:29:05	2025-08-02 21:29:05
4	1	50.00	2025-08-04 12:52:48	2025-08-04 12:53:23
4	2	50.00	2025-08-04 12:53:30	2025-08-04 12:53:30
\.


--
-- Data for Name: lots; Type: TABLE DATA; Schema: public; Owner: sail
--

COPY public.lots (id_lot, id_residence, numero_lot, nombre_tantiemes, statut, created_at, updated_at) FROM stdin;
1	1	A101	120	t	2025-08-02 21:29:03	2025-08-02 21:29:03
2	2	B205	150	t	2025-08-02 21:29:03	2025-08-02 21:29:03
3	3	Appt 5	95	t	2025-08-02 21:29:03	2025-08-02 21:29:03
4	4	Test 25	150	t	2025-08-04 12:52:12	2025-08-04 12:52:29
\.


--
-- Data for Name: migrations; Type: TABLE DATA; Schema: public; Owner: sail
--

COPY public.migrations (id, migration, batch) FROM stdin;
1	0001_01_01_000000_create_users_table	1
2	0001_01_01_000001_create_cache_table	1
3	0001_01_01_000002_create_jobs_table	1
4	2025_07_28_175845_create_langues_table	1
5	2025_07_28_175855_create_syndics_table	1
6	2025_07_28_175904_create_coproprietes_table	1
7	2025_07_28_175913_create_residences_table	1
8	2025_07_28_175921_create_lots_table	1
9	2025_07_28_175930_create_proprietaires_table	1
10	2025_07_28_175938_create_lot_proprietaire_table	1
11	2025_07_28_175947_create_roles_table	1
12	2025_07_28_175956_create_permissions_table	1
13	2025_07_28_180010_create_role_has_permission_table	1
14	2025_07_28_180021_create_utilisateur_role_table	1
15	2025_07_28_180037_create_affectations_table	1
16	2025_07_28_185123_add_langue_preferee_to_users_table	1
\.


--
-- Data for Name: password_reset_tokens; Type: TABLE DATA; Schema: public; Owner: sail
--

COPY public.password_reset_tokens (email, token, created_at) FROM stdin;
\.


--
-- Data for Name: permissions; Type: TABLE DATA; Schema: public; Owner: sail
--

COPY public.permissions (id_permission, cle, nom_permission, created_at, updated_at) FROM stdin;
1	syndic:voir	{"fr":"Voir Syndics","en":"View Syndics"}	2025-08-02 21:29:03	2025-08-02 21:29:03
2	syndic:creer	{"fr":"Cr\\u00e9er Syndic","en":"Create Syndic"}	2025-08-02 21:29:03	2025-08-02 21:29:03
3	syndic:modifier	{"fr":"Modifier Syndic","en":"Edit Syndic"}	2025-08-02 21:29:03	2025-08-02 21:29:03
4	syndic:supprimer	{"fr":"Supprimer Syndic","en":"Delete Syndic"}	2025-08-02 21:29:03	2025-08-02 21:29:03
5	copropriete:voir	{"fr":"Voir Copropri\\u00e9t\\u00e9s","en":"View Condominiums"}	2025-08-02 21:29:03	2025-08-02 21:29:03
6	copropriete:creer	{"fr":"Cr\\u00e9er Copropri\\u00e9t\\u00e9","en":"Create Condominium"}	2025-08-02 21:29:03	2025-08-02 21:29:03
7	copropriete:modifier	{"fr":"Modifier Copropri\\u00e9t\\u00e9","en":"Edit Condominium"}	2025-08-02 21:29:03	2025-08-02 21:29:03
8	copropriete:supprimer	{"fr":"Supprimer Copropri\\u00e9t\\u00e9","en":"Delete Condominium"}	2025-08-02 21:29:03	2025-08-02 21:29:03
9	residence:voir	{"fr":"Voir R\\u00e9sidences\\/B\\u00e2timents","en":"View Residences\\/Buildings"}	2025-08-02 21:29:03	2025-08-02 21:29:03
10	residence:creer	{"fr":"Cr\\u00e9er R\\u00e9sidence\\/B\\u00e2timent","en":"Create Residence\\/Building"}	2025-08-02 21:29:03	2025-08-02 21:29:03
11	residence:modifier	{"fr":"Modifier R\\u00e9sidence\\/B\\u00e2timent","en":"Edit Residence\\/Building"}	2025-08-02 21:29:03	2025-08-02 21:29:03
12	residence:supprimer	{"fr":"Supprimer R\\u00e9sidence\\/B\\u00e2timent","en":"Delete Residence\\/Building"}	2025-08-02 21:29:03	2025-08-02 21:29:03
13	lot:voir	{"fr":"Voir Lots","en":"View Lots"}	2025-08-02 21:29:03	2025-08-02 21:29:03
14	lot:creer	{"fr":"Cr\\u00e9er Lot","en":"Create Lot"}	2025-08-02 21:29:03	2025-08-02 21:29:03
15	lot:modifier	{"fr":"Modifier Lot","en":"Edit Lot"}	2025-08-02 21:29:03	2025-08-02 21:29:03
16	lot:supprimer	{"fr":"Supprimer Lot","en":"Delete Lot"}	2025-08-02 21:29:03	2025-08-02 21:29:03
17	proprietaire:voir	{"fr":"Voir Propri\\u00e9taires","en":"View Owners"}	2025-08-02 21:29:03	2025-08-02 21:29:03
18	proprietaire:creer	{"fr":"Cr\\u00e9er Propri\\u00e9taire","en":"Create Owner"}	2025-08-02 21:29:03	2025-08-02 21:29:03
19	proprietaire:modifier	{"fr":"Modifier Propri\\u00e9taire","en":"Edit Owner"}	2025-08-02 21:29:03	2025-08-02 21:29:03
20	proprietaire:supprimer	{"fr":"Supprimer Propri\\u00e9taire","en":"Delete Owner"}	2025-08-02 21:29:03	2025-08-02 21:29:03
21	role:voir	{"fr":"Voir R\\u00f4les","en":"View Roles"}	2025-08-02 21:29:03	2025-08-02 21:29:03
22	role:modifier	{"fr":"Modifier R\\u00f4les & Permissions","en":"Edit Roles & Permissions"}	2025-08-02 21:29:03	2025-08-02 21:29:03
23	utilisateur:voir	{"fr":"Voir Utilisateurs","en":"View Users"}	2025-08-02 21:29:03	2025-08-02 21:29:03
24	utilisateur:modifier	{"fr":"Modifier Utilisateurs & R\\u00f4les","en":"Edit Users & Roles"}	2025-08-02 21:29:03	2025-08-02 21:29:03
\.


--
-- Data for Name: proprietaires; Type: TABLE DATA; Schema: public; Owner: sail
--

COPY public.proprietaires (id_proprietaire, id_utilisateur, type_proprietaire, nom, email, telephone_contact, adresse_postale, code_postal, ville, pays, civilite, prenom, date_naissance, forme_juridique, numero_siret, iban, bic, commentaires, statut, created_at, updated_at) FROM stdin;
1	\N	personne_physique	Dupont	dupont@example.com	\N	\N	\N	\N	\N	\N	Paul	\N	\N	\N	\N	\N	\N	t	2025-08-02 21:29:05	2025-08-02 21:29:05
2	\N	personne_physique	Durand	durand@example.com	\N	\N	\N	\N	\N	\N	Marie	\N	\N	\N	\N	\N	\N	t	2025-08-02 21:29:05	2025-08-02 21:29:05
\.


--
-- Data for Name: residences; Type: TABLE DATA; Schema: public; Owner: sail
--

COPY public.residences (id_residence, id_copropriete, nom_residence, adresse, code_postal, ville, statut, created_at, updated_at) FROM stdin;
1	1	Les Tilleuls (Bât. A)	\N	\N	\N	t	2025-08-02 21:29:03	2025-08-02 21:29:03
2	1	Les Chênes (Bât. B)	\N	\N	\N	t	2025-08-02 21:29:03	2025-08-02 21:29:03
3	2	Les Nénuphars	\N	\N	\N	t	2025-08-02 21:29:03	2025-08-02 21:29:03
4	1	Residence Test 1	10 rue pola	20000	Casablanca	t	2025-08-04 12:51:34	2025-08-04 12:51:34
\.


--
-- Data for Name: role_has_permission; Type: TABLE DATA; Schema: public; Owner: sail
--

COPY public.role_has_permission (id_role, id_permission) FROM stdin;
1	1
1	2
1	3
1	4
1	5
1	6
1	7
1	8
1	9
1	10
1	11
1	12
1	13
1	14
1	15
1	16
1	17
1	18
1	19
1	20
1	21
1	22
1	23
1	24
2	1
2	5
2	9
2	13
2	17
\.


--
-- Data for Name: roles; Type: TABLE DATA; Schema: public; Owner: sail
--

COPY public.roles (id_role, nom_role, created_at, updated_at) FROM stdin;
1	{"fr":"Super Administrateur","en":"Super Administrator"}	2025-08-02 21:29:03	2025-08-02 21:29:03
2	{"fr":"Gestionnaire","en":"Manager"}	2025-08-02 21:29:03	2025-08-02 21:29:03
3	{"fr":"Propri\\u00e9taire","en":"Owner"}	2025-08-02 21:29:03	2025-08-02 21:29:03
\.


--
-- Data for Name: sessions; Type: TABLE DATA; Schema: public; Owner: sail
--

COPY public.sessions (id, user_id, ip_address, user_agent, payload, last_activity) FROM stdin;
37JLWXDOsJPCqgH4hmzDvlvcZsFWlki3xaSnQ0qr	1	172.18.0.1	Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:141.0) Gecko/20100101 Firefox/141.0	YTo0OntzOjY6Il90b2tlbiI7czo0MDoiZE4xemhod0RSNnhOeHJBNTI3NmxOZ2R3RUthc0lsUzRqUld4YnVoMCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzM6Imh0dHA6Ly9sb2NhbGhvc3QvYWRtaW4vcmVzaWRlbmNlcyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==	1754317356
\.


--
-- Data for Name: syndics; Type: TABLE DATA; Schema: public; Owner: sail
--

COPY public.syndics (id_syndic, nom_entreprise, statut, created_at, updated_at) FROM stdin;
1	Syndic A - Paris Gérance	t	2025-08-02 21:29:03	2025-08-02 21:29:03
2	Syndic B - Immo Sud	t	2025-08-02 21:29:03	2025-08-02 21:29:03
\.


--
-- Data for Name: users; Type: TABLE DATA; Schema: public; Owner: sail
--

COPY public.users (id, name, email, email_verified_at, password, remember_token, is_super_admin, created_at, updated_at, id_langue_preferee) FROM stdin;
2	Gaston Global	global@example.com	2025-08-02 21:29:05	$2y$12$Kk6aan1PW9o26X4Q30dvz.ti1doFGwfLR3UxF3J5qVVC1D0gEGlj6	VoMaLw13Ns	f	2025-08-02 21:29:05	2025-08-02 21:29:05	\N
3	Gisele Spécifique (Copro Parc)	specifique@example.com	2025-08-02 21:29:06	$2y$12$/f851Zw63g0kIPQewhj7teDNq5HdKlW50V4mUMAkkVcB3Bid8Rcia	0kjzVfDNbb	f	2025-08-02 21:29:06	2025-08-02 21:29:06	\N
1	Super Admin	admin@example.com	2025-08-02 21:29:04	$2y$12$xNmwnBYW8aUtBK6VybYWA.aRtA.0qb2561M2dfuIehvgVKo23KeT6	d9LQAVBJJ4	t	2025-08-02 21:29:05	2025-08-04 14:09:21	2
\.


--
-- Data for Name: utilisateur_role; Type: TABLE DATA; Schema: public; Owner: sail
--

COPY public.utilisateur_role (user_id, id_role) FROM stdin;
2	2
\.


--
-- Name: affectations_id_affectation_seq; Type: SEQUENCE SET; Schema: public; Owner: sail
--

SELECT pg_catalog.setval('public.affectations_id_affectation_seq', 1, true);


--
-- Name: coproprietes_id_copropriete_seq; Type: SEQUENCE SET; Schema: public; Owner: sail
--

SELECT pg_catalog.setval('public.coproprietes_id_copropriete_seq', 3, true);


--
-- Name: failed_jobs_id_seq; Type: SEQUENCE SET; Schema: public; Owner: sail
--

SELECT pg_catalog.setval('public.failed_jobs_id_seq', 1, false);


--
-- Name: jobs_id_seq; Type: SEQUENCE SET; Schema: public; Owner: sail
--

SELECT pg_catalog.setval('public.jobs_id_seq', 1, false);


--
-- Name: langues_id_langue_seq; Type: SEQUENCE SET; Schema: public; Owner: sail
--

SELECT pg_catalog.setval('public.langues_id_langue_seq', 2, true);


--
-- Name: lots_id_lot_seq; Type: SEQUENCE SET; Schema: public; Owner: sail
--

SELECT pg_catalog.setval('public.lots_id_lot_seq', 4, true);


--
-- Name: migrations_id_seq; Type: SEQUENCE SET; Schema: public; Owner: sail
--

SELECT pg_catalog.setval('public.migrations_id_seq', 16, true);


--
-- Name: permissions_id_permission_seq; Type: SEQUENCE SET; Schema: public; Owner: sail
--

SELECT pg_catalog.setval('public.permissions_id_permission_seq', 24, true);


--
-- Name: proprietaires_id_proprietaire_seq; Type: SEQUENCE SET; Schema: public; Owner: sail
--

SELECT pg_catalog.setval('public.proprietaires_id_proprietaire_seq', 2, true);


--
-- Name: residences_id_residence_seq; Type: SEQUENCE SET; Schema: public; Owner: sail
--

SELECT pg_catalog.setval('public.residences_id_residence_seq', 5, true);


--
-- Name: roles_id_role_seq; Type: SEQUENCE SET; Schema: public; Owner: sail
--

SELECT pg_catalog.setval('public.roles_id_role_seq', 3, true);


--
-- Name: syndics_id_syndic_seq; Type: SEQUENCE SET; Schema: public; Owner: sail
--

SELECT pg_catalog.setval('public.syndics_id_syndic_seq', 3, true);


--
-- Name: users_id_seq; Type: SEQUENCE SET; Schema: public; Owner: sail
--

SELECT pg_catalog.setval('public.users_id_seq', 3, true);


--
-- Name: affectations affectations_pkey; Type: CONSTRAINT; Schema: public; Owner: sail
--

ALTER TABLE ONLY public.affectations
    ADD CONSTRAINT affectations_pkey PRIMARY KEY (id_affectation);


--
-- Name: cache_locks cache_locks_pkey; Type: CONSTRAINT; Schema: public; Owner: sail
--

ALTER TABLE ONLY public.cache_locks
    ADD CONSTRAINT cache_locks_pkey PRIMARY KEY (key);


--
-- Name: cache cache_pkey; Type: CONSTRAINT; Schema: public; Owner: sail
--

ALTER TABLE ONLY public.cache
    ADD CONSTRAINT cache_pkey PRIMARY KEY (key);


--
-- Name: coproprietes coproprietes_pkey; Type: CONSTRAINT; Schema: public; Owner: sail
--

ALTER TABLE ONLY public.coproprietes
    ADD CONSTRAINT coproprietes_pkey PRIMARY KEY (id_copropriete);


--
-- Name: failed_jobs failed_jobs_pkey; Type: CONSTRAINT; Schema: public; Owner: sail
--

ALTER TABLE ONLY public.failed_jobs
    ADD CONSTRAINT failed_jobs_pkey PRIMARY KEY (id);


--
-- Name: failed_jobs failed_jobs_uuid_unique; Type: CONSTRAINT; Schema: public; Owner: sail
--

ALTER TABLE ONLY public.failed_jobs
    ADD CONSTRAINT failed_jobs_uuid_unique UNIQUE (uuid);


--
-- Name: job_batches job_batches_pkey; Type: CONSTRAINT; Schema: public; Owner: sail
--

ALTER TABLE ONLY public.job_batches
    ADD CONSTRAINT job_batches_pkey PRIMARY KEY (id);


--
-- Name: jobs jobs_pkey; Type: CONSTRAINT; Schema: public; Owner: sail
--

ALTER TABLE ONLY public.jobs
    ADD CONSTRAINT jobs_pkey PRIMARY KEY (id);


--
-- Name: langues langues_code_langue_unique; Type: CONSTRAINT; Schema: public; Owner: sail
--

ALTER TABLE ONLY public.langues
    ADD CONSTRAINT langues_code_langue_unique UNIQUE (code_langue);


--
-- Name: langues langues_pkey; Type: CONSTRAINT; Schema: public; Owner: sail
--

ALTER TABLE ONLY public.langues
    ADD CONSTRAINT langues_pkey PRIMARY KEY (id_langue);


--
-- Name: lot_proprietaire lot_proprietaire_pkey; Type: CONSTRAINT; Schema: public; Owner: sail
--

ALTER TABLE ONLY public.lot_proprietaire
    ADD CONSTRAINT lot_proprietaire_pkey PRIMARY KEY (id_lot, id_proprietaire);


--
-- Name: lots lots_pkey; Type: CONSTRAINT; Schema: public; Owner: sail
--

ALTER TABLE ONLY public.lots
    ADD CONSTRAINT lots_pkey PRIMARY KEY (id_lot);


--
-- Name: migrations migrations_pkey; Type: CONSTRAINT; Schema: public; Owner: sail
--

ALTER TABLE ONLY public.migrations
    ADD CONSTRAINT migrations_pkey PRIMARY KEY (id);


--
-- Name: password_reset_tokens password_reset_tokens_pkey; Type: CONSTRAINT; Schema: public; Owner: sail
--

ALTER TABLE ONLY public.password_reset_tokens
    ADD CONSTRAINT password_reset_tokens_pkey PRIMARY KEY (email);


--
-- Name: permissions permissions_cle_unique; Type: CONSTRAINT; Schema: public; Owner: sail
--

ALTER TABLE ONLY public.permissions
    ADD CONSTRAINT permissions_cle_unique UNIQUE (cle);


--
-- Name: permissions permissions_pkey; Type: CONSTRAINT; Schema: public; Owner: sail
--

ALTER TABLE ONLY public.permissions
    ADD CONSTRAINT permissions_pkey PRIMARY KEY (id_permission);


--
-- Name: proprietaires proprietaires_pkey; Type: CONSTRAINT; Schema: public; Owner: sail
--

ALTER TABLE ONLY public.proprietaires
    ADD CONSTRAINT proprietaires_pkey PRIMARY KEY (id_proprietaire);


--
-- Name: residences residences_pkey; Type: CONSTRAINT; Schema: public; Owner: sail
--

ALTER TABLE ONLY public.residences
    ADD CONSTRAINT residences_pkey PRIMARY KEY (id_residence);


--
-- Name: role_has_permission role_has_permission_pkey; Type: CONSTRAINT; Schema: public; Owner: sail
--

ALTER TABLE ONLY public.role_has_permission
    ADD CONSTRAINT role_has_permission_pkey PRIMARY KEY (id_role, id_permission);


--
-- Name: roles roles_pkey; Type: CONSTRAINT; Schema: public; Owner: sail
--

ALTER TABLE ONLY public.roles
    ADD CONSTRAINT roles_pkey PRIMARY KEY (id_role);


--
-- Name: sessions sessions_pkey; Type: CONSTRAINT; Schema: public; Owner: sail
--

ALTER TABLE ONLY public.sessions
    ADD CONSTRAINT sessions_pkey PRIMARY KEY (id);


--
-- Name: syndics syndics_pkey; Type: CONSTRAINT; Schema: public; Owner: sail
--

ALTER TABLE ONLY public.syndics
    ADD CONSTRAINT syndics_pkey PRIMARY KEY (id_syndic);


--
-- Name: users users_email_unique; Type: CONSTRAINT; Schema: public; Owner: sail
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_email_unique UNIQUE (email);


--
-- Name: users users_pkey; Type: CONSTRAINT; Schema: public; Owner: sail
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_pkey PRIMARY KEY (id);


--
-- Name: utilisateur_role utilisateur_role_pkey; Type: CONSTRAINT; Schema: public; Owner: sail
--

ALTER TABLE ONLY public.utilisateur_role
    ADD CONSTRAINT utilisateur_role_pkey PRIMARY KEY (user_id, id_role);


--
-- Name: affectations_affectable_type_affectable_id_index; Type: INDEX; Schema: public; Owner: sail
--

CREATE INDEX affectations_affectable_type_affectable_id_index ON public.affectations USING btree (affectable_type, affectable_id);


--
-- Name: jobs_queue_index; Type: INDEX; Schema: public; Owner: sail
--

CREATE INDEX jobs_queue_index ON public.jobs USING btree (queue);


--
-- Name: sessions_last_activity_index; Type: INDEX; Schema: public; Owner: sail
--

CREATE INDEX sessions_last_activity_index ON public.sessions USING btree (last_activity);


--
-- Name: sessions_user_id_index; Type: INDEX; Schema: public; Owner: sail
--

CREATE INDEX sessions_user_id_index ON public.sessions USING btree (user_id);


--
-- Name: affectations affectations_id_role_foreign; Type: FK CONSTRAINT; Schema: public; Owner: sail
--

ALTER TABLE ONLY public.affectations
    ADD CONSTRAINT affectations_id_role_foreign FOREIGN KEY (id_role) REFERENCES public.roles(id_role) ON DELETE CASCADE;


--
-- Name: affectations affectations_id_utilisateur_foreign; Type: FK CONSTRAINT; Schema: public; Owner: sail
--

ALTER TABLE ONLY public.affectations
    ADD CONSTRAINT affectations_id_utilisateur_foreign FOREIGN KEY (id_utilisateur) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- Name: coproprietes coproprietes_id_syndic_foreign; Type: FK CONSTRAINT; Schema: public; Owner: sail
--

ALTER TABLE ONLY public.coproprietes
    ADD CONSTRAINT coproprietes_id_syndic_foreign FOREIGN KEY (id_syndic) REFERENCES public.syndics(id_syndic) ON DELETE CASCADE;


--
-- Name: lot_proprietaire lot_proprietaire_id_lot_foreign; Type: FK CONSTRAINT; Schema: public; Owner: sail
--

ALTER TABLE ONLY public.lot_proprietaire
    ADD CONSTRAINT lot_proprietaire_id_lot_foreign FOREIGN KEY (id_lot) REFERENCES public.lots(id_lot) ON DELETE CASCADE;


--
-- Name: lot_proprietaire lot_proprietaire_id_proprietaire_foreign; Type: FK CONSTRAINT; Schema: public; Owner: sail
--

ALTER TABLE ONLY public.lot_proprietaire
    ADD CONSTRAINT lot_proprietaire_id_proprietaire_foreign FOREIGN KEY (id_proprietaire) REFERENCES public.proprietaires(id_proprietaire) ON DELETE CASCADE;


--
-- Name: lots lots_id_residence_foreign; Type: FK CONSTRAINT; Schema: public; Owner: sail
--

ALTER TABLE ONLY public.lots
    ADD CONSTRAINT lots_id_residence_foreign FOREIGN KEY (id_residence) REFERENCES public.residences(id_residence) ON DELETE CASCADE;


--
-- Name: proprietaires proprietaires_id_utilisateur_foreign; Type: FK CONSTRAINT; Schema: public; Owner: sail
--

ALTER TABLE ONLY public.proprietaires
    ADD CONSTRAINT proprietaires_id_utilisateur_foreign FOREIGN KEY (id_utilisateur) REFERENCES public.users(id) ON DELETE SET NULL;


--
-- Name: residences residences_id_copropriete_foreign; Type: FK CONSTRAINT; Schema: public; Owner: sail
--

ALTER TABLE ONLY public.residences
    ADD CONSTRAINT residences_id_copropriete_foreign FOREIGN KEY (id_copropriete) REFERENCES public.coproprietes(id_copropriete) ON DELETE CASCADE;


--
-- Name: role_has_permission role_has_permission_id_permission_foreign; Type: FK CONSTRAINT; Schema: public; Owner: sail
--

ALTER TABLE ONLY public.role_has_permission
    ADD CONSTRAINT role_has_permission_id_permission_foreign FOREIGN KEY (id_permission) REFERENCES public.permissions(id_permission) ON DELETE CASCADE;


--
-- Name: role_has_permission role_has_permission_id_role_foreign; Type: FK CONSTRAINT; Schema: public; Owner: sail
--

ALTER TABLE ONLY public.role_has_permission
    ADD CONSTRAINT role_has_permission_id_role_foreign FOREIGN KEY (id_role) REFERENCES public.roles(id_role) ON DELETE CASCADE;


--
-- Name: users users_id_langue_preferee_foreign; Type: FK CONSTRAINT; Schema: public; Owner: sail
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_id_langue_preferee_foreign FOREIGN KEY (id_langue_preferee) REFERENCES public.langues(id_langue) ON DELETE SET NULL;


--
-- Name: utilisateur_role utilisateur_role_id_role_foreign; Type: FK CONSTRAINT; Schema: public; Owner: sail
--

ALTER TABLE ONLY public.utilisateur_role
    ADD CONSTRAINT utilisateur_role_id_role_foreign FOREIGN KEY (id_role) REFERENCES public.roles(id_role) ON DELETE CASCADE;


--
-- Name: utilisateur_role utilisateur_role_user_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: sail
--

ALTER TABLE ONLY public.utilisateur_role
    ADD CONSTRAINT utilisateur_role_user_id_foreign FOREIGN KEY (user_id) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- PostgreSQL database dump complete
--

