-- ----------------------------------------------------------------------------
-- MySQL Workbench Migration
-- Migrated Schemata: db_perriatra
-- Source Schemata: db_perriatra
-- Created: Thu May 22 21:13:44 2025
-- Workbench Version: 8.0.41
-- ----------------------------------------------------------------------------

SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------------------------------------------------------
-- Schema db_perriatra
-- ----------------------------------------------------------------------------
DROP SCHEMA IF EXISTS `db_perriatra` ;
CREATE SCHEMA IF NOT EXISTS `db_perriatra` ;

-- ----------------------------------------------------------------------------
-- Table db_perriatra.especialidad
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_perriatra`.`especialidad` (
  `id_especialidad` INT NOT NULL AUTO_INCREMENT,
  `Nombre_e` VARCHAR(60) NULL DEFAULT NULL,
  `Descripcion_e` VARCHAR(255) NULL DEFAULT NULL,
  PRIMARY KEY (`id_especialidad`))
ENGINE = InnoDB
AUTO_INCREMENT = 11
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;

-- ----------------------------------------------------------------------------
-- Table db_perriatra.historial
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_perriatra`.`historial` (
  `id_historial` INT NOT NULL AUTO_INCREMENT,
  `observacion_his` VARCHAR(255) CHARACTER SET 'utf8mb4' COLLATE 'utf8mb4_0900_ai_ci' NULL DEFAULT NULL,
  `fecha-entrada_his` DATE NULL DEFAULT NULL,
  `fecha-salida_his` DATE NULL DEFAULT NULL,
  `ingresado_his` VARCHAR(2) NULL DEFAULT NULL,
  `mascota` INT NULL DEFAULT NULL,
  `veterinario` INT NULL DEFAULT NULL,
  PRIMARY KEY (`id_historial`),
  INDEX `mascota_idx` (`mascota` ASC) VISIBLE,
  INDEX `fk_veterinario` (`veterinario` ASC) VISIBLE,
  CONSTRAINT `fk_veterinario`
    FOREIGN KEY (`veterinario`)
    REFERENCES `db_perriatra`.`veterinario` (`Id_Vet`),
  CONSTRAINT `mascota`
    FOREIGN KEY (`mascota`)
    REFERENCES `db_perriatra`.`mascota` (`Chip`))
ENGINE = InnoDB
AUTO_INCREMENT = 27
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_unicode_ci;

-- ----------------------------------------------------------------------------
-- Table db_perriatra.mascota
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_perriatra`.`mascota` (
  `Chip` INT NOT NULL AUTO_INCREMENT,
  `Nombre` VARCHAR(25) NOT NULL,
  `Sexo` VARCHAR(1) NOT NULL,
  `Fecha_Nacimiento` DATE NOT NULL,
  `Especie` VARCHAR(8) NOT NULL,
  `Raza` INT NOT NULL,
  `Propietario` INT NOT NULL,
  `Veterinario` INT NOT NULL,
  PRIMARY KEY (`Chip`),
  INDEX `mascota_raza_fk` (`Raza` ASC) VISIBLE,
  INDEX `mascota_propietario_fk` (`Propietario` ASC) VISIBLE,
  INDEX `mascota_veterinario_fk` (`Veterinario` ASC) VISIBLE,
  CONSTRAINT `Propetario`
    FOREIGN KEY (`Propietario`)
    REFERENCES `db_perriatra`.`propietario` (`DNI`)
    ON DELETE CASCADE,
  CONSTRAINT `Raza`
    FOREIGN KEY (`Raza`)
    REFERENCES `db_perriatra`.`raza` (`Id_Raza`)
    ON DELETE CASCADE,
  CONSTRAINT `Veterinario`
    FOREIGN KEY (`Veterinario`)
    REFERENCES `db_perriatra`.`veterinario` (`Id_Vet`)
    ON DELETE CASCADE)
ENGINE = InnoDB
AUTO_INCREMENT = 3326
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;

-- ----------------------------------------------------------------------------
-- Table db_perriatra.personal
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_perriatra`.`personal` (
  `id_personal` INT NOT NULL AUTO_INCREMENT,
  `nom_personal` VARCHAR(45) NULL DEFAULT NULL,
  `contra_personal` VARCHAR(255) NULL DEFAULT NULL,
  `email_personal` VARCHAR(45) NULL DEFAULT NULL,
  PRIMARY KEY (`id_personal`))
ENGINE = InnoDB
AUTO_INCREMENT = 14
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;

-- ----------------------------------------------------------------------------
-- Table db_perriatra.propietario
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_perriatra`.`propietario` (
  `DNI` INT NOT NULL,
  `Nombre` VARCHAR(55) NOT NULL,
  `Direccion` TEXT NULL DEFAULT NULL,
  `Telefono` INT NOT NULL,
  `Email` VARCHAR(50) NULL DEFAULT NULL,
  PRIMARY KEY (`DNI`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;

-- ----------------------------------------------------------------------------
-- Table db_perriatra.raza
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_perriatra`.`raza` (
  `Id_Raza` INT NOT NULL AUTO_INCREMENT,
  `Nombre` VARCHAR(25) NOT NULL,
  `Altura` INT NULL DEFAULT NULL,
  `Peso` INT NULL DEFAULT NULL,
  `Caracter` VARCHAR(25) NULL DEFAULT NULL,
  PRIMARY KEY (`Id_Raza`))
ENGINE = InnoDB
AUTO_INCREMENT = 115
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;

-- ----------------------------------------------------------------------------
-- Table db_perriatra.veterinario
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_perriatra`.`veterinario` (
  `Id_Vet` INT NOT NULL AUTO_INCREMENT,
  `Nombre` VARCHAR(25) NOT NULL,
  `Telefono` VARCHAR(15) NULL DEFAULT NULL,
  `Especialidad` VARCHAR(20) NULL DEFAULT NULL,
  `Fecha_Contrato` DATE NOT NULL,
  `Salario` INT NOT NULL,
  `fkespecialidad` INT NULL DEFAULT NULL,
  PRIMARY KEY (`Id_Vet`),
  INDEX `fkespecialidad_idx` (`fkespecialidad` ASC) VISIBLE,
  CONSTRAINT `fkespecialidad`
    FOREIGN KEY (`fkespecialidad`)
    REFERENCES `db_perriatra`.`especialidad` (`id_especialidad`))
ENGINE = InnoDB
AUTO_INCREMENT = 31
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;
SET FOREIGN_KEY_CHECKS = 1;
