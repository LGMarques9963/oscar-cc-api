create table if not exists `Moradores` (
    `Nome` varchar(255) not null
);

create table if not exists `Categorias` (
    `tituloCategoria` varchar(255) not null
);

create table if not exists `Votos` (
    `Morador` int(11) not null,
    `tituloCategoria` int(11) not null,
    `pontuacao` int(11) not null
);
