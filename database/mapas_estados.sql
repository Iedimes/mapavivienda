/*
 Navicat Premium Data Transfer

 Source Server         : local
 Source Server Type    : PostgreSQL
 Source Server Version : 90615
 Source Host           : localhost:5432
 Source Catalog        : mapa
 Source Schema         : public

 Target Server Type    : PostgreSQL
 Target Server Version : 90615
 File Encoding         : 65001

 Date: 23/07/2020 11:29:30
*/


-- ----------------------------
-- Sequence structure for estados_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "estados_id_seq";
CREATE SEQUENCE "estados_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 9
CACHE 1;

-- ----------------------------
-- Table structure for estados
-- ----------------------------
DROP TABLE IF EXISTS "estados";
CREATE TABLE "estados" (
  "id" int4 NOT NULL DEFAULT nextval('estados_id_seq'::regclass),
  "name" varchar(191) COLLATE "pg_catalog"."default" NOT NULL,
  "value" varchar(191) COLLATE "pg_catalog"."default" NOT NULL,
  "created_at" timestamp(6),
  "updated_at" timestamp(6)
)
;

-- ----------------------------
-- Records of estados
-- ----------------------------
BEGIN;
INSERT INTO "estados" VALUES (1, 'En Proyecto', 'Y', NULL, NULL);
INSERT INTO "estados" VALUES (2, 'Descartado', 'S', NULL, NULL);
INSERT INTO "estados" VALUES (3, 'A Iniciar', 'I', NULL, NULL);
INSERT INTO "estados" VALUES (4, 'Pendiente', 'D', NULL, NULL);
INSERT INTO "estados" VALUES (5, 'En Ejecución', 'E', NULL, NULL);
INSERT INTO "estados" VALUES (6, 'Culminado', 'C', NULL, NULL);
INSERT INTO "estados" VALUES (7, 'Paralizado', 'P', NULL, NULL);
INSERT INTO "estados" VALUES (8, 'Rescindido', 'R', NULL, NULL);
INSERT INTO "estados" VALUES (9, 'Anulado', 'A', NULL, NULL);
COMMIT;

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "estados_id_seq"
OWNED BY "estados"."id";
SELECT setval('"estados_id_seq"', 12, true);

-- ----------------------------
-- Primary Key structure for table estados
-- ----------------------------
ALTER TABLE "estados" ADD CONSTRAINT "estados_pkey" PRIMARY KEY ("id");
