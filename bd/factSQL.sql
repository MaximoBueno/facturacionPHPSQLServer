CREATE DATABASE factSQL
GO

USE factSQL
GO

CREATE TABLE Cliente(
id_cliente INT IDENTITY (1,1),
razon_social VARCHAR(200) NOT NULL,
ruc VARCHAR(20) NOT NULL,
estado INT DEFAULT '1',
fecha_crea DATETIME DEFAULT GETDATE()
)
GO

INSERT INTO Cliente(razon_social, ruc) VALUES('Empresa 1', '12345678911');
INSERT INTO Cliente(razon_social, ruc) VALUES('Empresa 2', '12345678912');
INSERT INTO Cliente(razon_social, ruc) VALUES('Empresa 3', '12345678913');
INSERT INTO Cliente(razon_social, ruc) VALUES('Empresa 4', '12345678914');

CREATE PROCEDURE getBusquedaCliente(
@razon_social VARCHAR(200) = NULL
)
AS
SELECT TOP 20 id_cliente, razon_social, ruc
FROM Cliente
WHERE estado = 1 AND razon_social LIKE '%' + @razon_social + '%'
GO


CREATE TABLE Servicio(
id_servicio INT IDENTITY(1,1),
nombre VARCHAR(200) NOT NULL,
precio DECIMAL (9,2) NOT NULL,
estado INT DEFAULT '1',
fecha_crea DATETIME DEFAULT GETDATE()
)
GO

INSERT INTO Servicio(nombre, precio) VALUES('Consultoria Juridica', 1200.00);
INSERT INTO Servicio(nombre, precio) VALUES('Auditoria de TI', 1000.00);
INSERT INTO Servicio(nombre, precio) VALUES('ISO 9001', 15000.00);
INSERT INTO Servicio(nombre, precio) VALUES('Auditoria Contable', 4500.00);


CREATE PROCEDURE getBusquedaServicio(
@nombre VARCHAR(200) = NULL
)
AS
SELECT TOP 20 id_servicio, nombre, precio
FROM Servicio
WHERE estado = 1 AND nombre LIKE '%' + @nombre + '%'
GO

--ADD
CREATE TABLE Numero_boleta(
id_numero_boleta INT IDENTITY(1,1),
usu_crea INT NOT NULL,
estado INT DEFAULT '1',
fecha_crea DATETIME DEFAULT GETDATE()
)
GO


CREATE PROCEDURE regNumeroBoleta(
@usuario INT = NULL,
@id_numero_boleta BIGINT OUTPUT) 
AS
BEGIN TRY
	INSERT INTO Numero_boleta(usu_crea) VALUES(@usuario);
	SET @id_numero_boleta = SCOPE_IDENTITY();
END TRY
BEGIN CATCH
		IF (XACT_STATE()) = -1
			ROLLBACK TRANSACTION

		IF (XACT_STATE()) = 1
			COMMIT TRANSACTION

	DECLARE @Message varchar(MAX) = ERROR_MESSAGE(),
        @Severity int = ERROR_SEVERITY(),
        @State smallint = ERROR_STATE()

	RAISERROR(@Message, @Severity, @State);
END CATCH
GO

CREATE TABLE Venta(
id_venta INT IDENTITY(1,1),
id_numero_boleta INT NOT NULL,
id_cliente INT NOT NULL,
id_servicio INT NOT NULL,
precio DECIMAL (9,2) NOT NULL,
estado INT DEFAULT '1',
fecha_crea DATETIME DEFAULT GETDATE()
)
GO

CREATE PROCEDURE regPagoServicio(
@datosPago NVARCHAR(MAX) =  NULL,
@id_cliente INT = NULL)
AS
BEGIN TRY
	IF(LEN(@datosPago)) > 70
	SET NOCOUNT ON;
			--OBTENGO EL NUMERO DE BOLETA
			DECLARE @id_numero_boleta INT
			EXEC regNumeroBoleta 1, @id_numero_boleta OUTPUT
			SELECT @id_numero_boleta AS 'Imprimir'

			--OBTENGO LOS DATOS DEL XML  
			DECLARE @DocHandle int  
			--CREO LA INSTANCIA XML
			EXEC sp_xml_preparedocument @DocHandle OUTPUT, @datosPago  
	
			--FILTRO LOS DATOS XML E LOS GUARDO
			INSERT INTO Venta(id_numero_boleta, id_cliente, id_servicio, precio)
			SELECT @id_numero_boleta AS 'id_numero_boleta', @id_cliente AS 'id_cliente', 
			CONVERT(INT, SUBSTRING(cod, 3, LEN(cod))) AS 'id_servicio', 
			pre AS 'precio'
			FROM OPENXML (@DocHandle, '/root/pension', @DocHandle)  
				  WITH (cod VARCHAR(20) ,  
						num INT,
						con VARCHAR(20),
						pre DECIMAL(9,2))

			EXEC sp_xml_removedocument @DocHandle

	IF(LEN(@datosPago)) < 70
			SELECT '00000000' AS 'Imprimir'
END TRY
BEGIN CATCH
		IF (XACT_STATE()) = -1
			ROLLBACK TRANSACTION

		IF (XACT_STATE()) = 1
			COMMIT TRANSACTION

	DECLARE @Message varchar(MAX) = ERROR_MESSAGE(),
        @Severity int = ERROR_SEVERITY(),
        @State smallint = ERROR_STATE()

	RAISERROR(@Message, @Severity, @State);

	SELECT '00000000' AS 'Imprimir'
END CATCH
GO

CREATE PROCEDURE imprimirBoleta(
@numero_boleta INT = NULL
)AS
SELECT V.id_venta, RIGHT('00000000' + CONVERT(VARCHAR(20), V.id_numero_boleta) ,8) AS 'id_numero_boleta',
C.ruc, C.razon_social, S.nombre AS 'servicio', S.precio, V.fecha_crea 
FROM Venta AS V
JOIN Cliente AS C 
ON V.id_cliente = C.id_cliente
JOIN Servicio AS S
ON V.id_servicio = S.id_servicio 
WHERE V.id_numero_boleta = @numero_boleta
ORDER BY V.id_venta
GO