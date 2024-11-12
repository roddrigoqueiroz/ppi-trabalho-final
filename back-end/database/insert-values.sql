BEGIN;

INSERT INTO ANUNCIO (MARCA, MODELO, ANO, QUILOMETRAGEM, DESCRICAO, VALOR, DATA_HORA, ESTADO, CIDADE, ID_ANUNCIANTE) VALUES
('Fiat', 'Mobi', 2015, 55000, 'Carro bem conservado, único dono', 30000, '2024-11-12 10:00:00', 'SP', 'São Paulo', 1),
('Volkswagen', 'Gol', 2018, 45000, 'Carro em excelente estado, manutenção em dia', 40000, '2024-10-11 15:30:00', 'RJ', 'Rio de Janeiro', 1),
('Chevrolet', 'Onix', 2020, 30000, 'Carro econômico, com IPVA pago', 50000, '2024-09-05 09:20:00', 'MG', 'Belo Horizonte', 1),
('Hyundai', 'HB20', 2019, 37000, 'Completo, ar-condicionado, direção hidráulica', 48000, '2024-08-20 16:10:00', 'SP', 'Campinas', 1),
('Toyota', 'Corolla', 2016, 60000, 'Excelente estado de conservação, segundo dono', 70000, '2024-07-10 13:45:00', 'RS', 'Porto Alegre', 1),
('Ford', 'Fiesta', 2017, 42000, 'Carro de garagem, único dono', 35000, '2024-06-01 08:15:00', 'PR', 'Curitiba', 1),
('Renault', 'Kwid', 2019, 28000, 'Muito econômico, ideal para cidade', 45000, '2024-05-18 11:30:00', 'BA', 'Salvador', 2),
('Fiat', 'Cronos', 2021, 15000, 'Carro com baixa quilometragem e excelente conforto', 110000, '2024-04-25 14:50:00', 'CE', 'Fortaleza', 2),
('Nissan', 'Kicks', 2022, 10000, 'SUV novo, ótima performance e segurança', 125000, '2024-03-12 17:20:00', 'PE', 'Recife', 3),
('Jeep', 'Renegade', 2018, 50000, 'SUV com revisões em dia, ótima dirigibilidade', 90000, '2024-02-02 12:10:00', 'GO', 'Goiânia', 3);

INSERT INTO FOTO (NOME_FOTO, ID_ANUNCIO, FLAG_CAPA) VALUES
('car-1.jpeg', 1, TRUE),
('car-2.jpeg', 2, TRUE),
('car-3.jpeg', 3, TRUE),
('car-4.jpeg', 4, TRUE),
('car-5.jpeg', 5, TRUE),
('car-6.jpeg', 6, TRUE),
('car-7.jpeg', 7, TRUE),
('car-8.jpeg', 8, TRUE),
('car-9.jpeg', 9, TRUE),
('car-10.jpeg', 10, TRUE);

--COMMIT;
--ROLLBACK;