--
-- PostgreSQL database dump
--

\restrict 7CBmoIZLbgAJ4QbaVeRIPfa1oCH7Bcn3lSybIiDodO9Lal4UYGzUtlZkMU4PF1Q

-- Dumped from database version 18.4 (Ubuntu 18.4-0ubuntu0.26.04.1)
-- Dumped by pg_dump version 18.4 (Ubuntu 18.4-0ubuntu0.26.04.1)

-- Started on 2026-10-22 09:52:15 UTC

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
-- TOC entry 222 (class 1259 OID 24761)
-- Name: clientes; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.clientes (
    id integer NOT NULL,
    nome character varying(100) NOT NULL,
    email character varying(100) NOT NULL,
    telefone character varying(20) NOT NULL,
    criado_em timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    servico text,
    data_retirada date,
    status character varying(50) DEFAULT 'Em Análise'::character varying
);


ALTER TABLE public.clientes OWNER TO postgres;

--
-- TOC entry 221 (class 1259 OID 24760)
-- Name: clientes_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.clientes_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.clientes_id_seq OWNER TO postgres;

--
-- TOC entry 3516 (class 0 OID 0)
-- Dependencies: 221
-- Name: clientes_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.clientes_id_seq OWNED BY public.clientes.id;


--
-- TOC entry 225 (class 1259 OID 24822)
-- Name: ferramentas; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.ferramentas (
    id integer NOT NULL,
    nome character varying(100) NOT NULL,
    categoria character varying(50) NOT NULL,
    quantidade integer DEFAULT 1 NOT NULL,
    estado character varying(50) DEFAULT 'Bom Estado'::character varying,
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE public.ferramentas OWNER TO postgres;

--
-- TOC entry 224 (class 1259 OID 24821)
-- Name: ferramentas_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.ferramentas_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.ferramentas_id_seq OWNER TO postgres;

--
-- TOC entry 3517 (class 0 OID 0)
-- Dependencies: 224
-- Name: ferramentas_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.ferramentas_id_seq OWNED BY public.ferramentas.id;


--
-- TOC entry 223 (class 1259 OID 24812)
-- Name: mural; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.mural (
    id integer DEFAULT 1 NOT NULL,
    aviso text,
    lembrete text,
    urgente text
);


ALTER TABLE public.mural OWNER TO postgres;

--
-- TOC entry 220 (class 1259 OID 24748)
-- Name: usuarios; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.usuarios (
    id integer NOT NULL,
    nome character varying(100) NOT NULL,
    email character varying(100) NOT NULL,
    senha character varying(255) NOT NULL
);


ALTER TABLE public.usuarios OWNER TO postgres;

--
-- TOC entry 219 (class 1259 OID 24747)
-- Name: usuarios_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.usuarios_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.usuarios_id_seq OWNER TO postgres;

--
-- TOC entry 3518 (class 0 OID 0)
-- Dependencies: 219
-- Name: usuarios_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.usuarios_id_seq OWNED BY public.usuarios.id;


--
-- TOC entry 3339 (class 2604 OID 24764)
-- Name: clientes id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.clientes ALTER COLUMN id SET DEFAULT nextval('public.clientes_id_seq'::regclass);


--
-- TOC entry 3343 (class 2604 OID 24825)
-- Name: ferramentas id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.ferramentas ALTER COLUMN id SET DEFAULT nextval('public.ferramentas_id_seq'::regclass);


--
-- TOC entry 3338 (class 2604 OID 24751)
-- Name: usuarios id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.usuarios ALTER COLUMN id SET DEFAULT nextval('public.usuarios_id_seq'::regclass);


--
-- TOC entry 3507 (class 0 OID 24761)
-- Dependencies: 222
-- Data for Name: clientes; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.clientes (id, nome, email, telefone, criado_em, servico, data_retirada, status) FROM stdin;
9	O cara mais suave daqui (Baiano)	baiano@gmail.com	123	2026-10-22 09:14:08.763121	🎮 6. Videogames - Limpeza interna	2026-10-25	Em Análise
\.


--
-- TOC entry 3510 (class 0 OID 24822)
-- Dependencies: 225
-- Data for Name: ferramentas; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.ferramentas (id, nome, categoria, quantidade, estado, created_at) FROM stdin;
2	Estação de Solda Ajustável	Soldadura	2	Bom Estado	2026-10-06 11:12:24.614049
3	Estação de Retrabalho Ar Quente / BGA	Soldadura	1	Bom Estado	2026-10-06 11:12:24.614049
4	Fonte de Alimentação Assimétrica (0-30V 5A)	Alimentação	2	Bom Estado	2026-10-06 11:12:24.614049
5	Jogo de Chaves de Precisão (Torx, Pentalobe, Phillips)	Manuais	4	Bom Estado	2026-10-06 11:12:24.614049
6	Manta Térmica Antiestática (ESD)	Proteção / Bancada	3	Bom Estado	2026-10-06 11:12:24.614049
7	Pinça Antiestática Curva e Reta	Manuais	5	Bom Estado	2026-10-06 11:12:24.614049
8	Espátula Plástica / Spudger para Abertura	Manuais	10	Bom Estado	2026-10-06 11:12:24.614049
9	Sugador de Solda de Alumínio	Soldadura	3	Bom Estado	2026-10-06 11:12:24.614049
10	Fio de Solda / Estanho Lead-Free	Consumíveis	5	Bom Estado	2026-10-06 11:12:24.614049
11	Fluxo de Solda Pastoso / Gel	Consumíveis	4	Bom Estado	2026-10-06 11:12:24.614049
12	Malha Dessoldadora de Cobre	Consumíveis	6	Bom Estado	2026-10-06 11:12:24.614049
13	Microscópio Trinocular Digital com Display	Diagnóstico	1	Bom Estado	2026-10-06 11:12:24.614049
14	Álcool Isopropílico 99.9% (1L)	Limpeza	3	Bom Estado	2026-10-06 11:12:24.614049
15	Cuba Ultrassónica de Limpeza	Limpeza	1	Bom Estado	2026-10-06 11:12:24.614049
16	Fita Térmica Kapton	Consumíveis	4	Bom Estado	2026-10-06 11:12:24.614049
17	Soprador Térmico Industrial	Manuais	1	Bom Estado	2026-10-06 11:12:24.614049
18	Testador de Cabos de Rede RJ45 / RJ11	Diagnóstico	2	Bom Estado	2026-10-06 11:12:24.614049
19	Alicate de Crimpagem RJ45	Redes	2	Bom Estado	2026-10-06 11:12:24.614049
20	Alicate de Corte Rente	Manuais	3	Bom Estado	2026-10-06 11:12:24.614049
21	Separadora de Ecrã / LCD a Vácuo	Equipamento	1	Bom Estado	2026-10-06 11:12:24.614049
22	Cola B7000 / T7000 para Ecrãs	Consumíveis	5	Bom Estado	2026-10-06 11:12:24.614049
23	Lupa de Bancada com LED e Braço Articulado	Iluminação	2	Bom Estado	2026-10-06 11:12:24.614049
24	Pulseira Antiestática ESD com Fio	Proteção / Bancada	4	Bom Estado	2026-10-06 11:12:24.614049
25	Ativador / Carregador de Baterias para Smartphone	Diagnóstico	2	Bom Estado	2026-10-06 11:12:24.614049
1	Multímetro Digital de Bancada	Diagnóstico	214	Bom Estado	2026-10-06 11:12:24.614049
\.


--
-- TOC entry 3508 (class 0 OID 24812)
-- Dependencies: 223
-- Data for Name: mural; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.mural (id, aviso, lembrete, urgente) FROM stdin;
\.


--
-- TOC entry 3505 (class 0 OID 24748)
-- Dependencies: 220
-- Data for Name: usuarios; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.usuarios (id, nome, email, senha) FROM stdin;
1	administrador	adm@adm.com	$2y$12$HMq1Woo9QRc6pHGf5bVUY.1DQ5OCR7a4TP3ZhvOSxSxe6fHMIvXtO
\.


--
-- TOC entry 3519 (class 0 OID 0)
-- Dependencies: 221
-- Name: clientes_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.clientes_id_seq', 9, true);


--
-- TOC entry 3520 (class 0 OID 0)
-- Dependencies: 224
-- Name: ferramentas_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.ferramentas_id_seq', 25, true);


--
-- TOC entry 3521 (class 0 OID 0)
-- Dependencies: 219
-- Name: usuarios_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.usuarios_id_seq', 1, true);


--
-- TOC entry 3352 (class 2606 OID 24771)
-- Name: clientes clientes_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.clientes
    ADD CONSTRAINT clientes_pkey PRIMARY KEY (id);


--
-- TOC entry 3356 (class 2606 OID 24834)
-- Name: ferramentas ferramentas_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.ferramentas
    ADD CONSTRAINT ferramentas_pkey PRIMARY KEY (id);


--
-- TOC entry 3354 (class 2606 OID 24820)
-- Name: mural mural_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.mural
    ADD CONSTRAINT mural_pkey PRIMARY KEY (id);


--
-- TOC entry 3348 (class 2606 OID 24759)
-- Name: usuarios usuarios_email_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.usuarios
    ADD CONSTRAINT usuarios_email_key UNIQUE (email);


--
-- TOC entry 3350 (class 2606 OID 24757)
-- Name: usuarios usuarios_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.usuarios
    ADD CONSTRAINT usuarios_pkey PRIMARY KEY (id);


-- Completed on 2026-10-22 09:52:18 UTC

--
-- PostgreSQL database dump complete
--

\unrestrict 7CBmoIZLbgAJ4QbaVeRIPfa1oCH7Bcn3lSybIiDodO9Lal4UYGzUtlZkMU4PF1Q

