USE `websiteartes`;

INSERT INTO usuario (nome, senha, adm, email, data_criacaoConta) VALUES ('admin','d033e22ae348aeb5660fc2140aec35850c4da997',1,'lucas.schwambach52@gmail.com','2017-01-01');

INSERT INTO `websiteartes`.`linguagensart` (`nome`, `descricao`)
VALUES ('Música','A música (do grego musiké téchne, a arte das musas) é uma forma de arte que se constitui na combinação de vários sons e ritmos, seguindo uma pré-organização ao longo do tempo.')
,('Literatura','A Literatura é a técnica de compor e expor textos escritos, em prosa ou em verso, de acordo com princípios teóricos e práticos; o exercício dessa técnica ou da eloquência e poesia.');

INSERT INTO `websiteartes`.`genero` (`nome`, `descricao`, `lingArte`)
VALUES ('Rock','Rock (ou roque) é um termo abrangente que define um gênero musical de música popular que se desenvolveu durante e após a década de 1950. Suas raízes se encontram no rock and roll e no rockabilly que emergiram e se definiram nos Estados Unidos no final dos anos quarenta e início dos cinquenta e que, por sua vez, evoluíram do blues, da música country e do rhythm and blues. Outras influências musicais sobre o rock ainda incluem o folk, o jazz e a música clássica. Todas estas influências foram combinadas em uma estrutura musical simples baseada no blues que era "rápida, dançável e pegajosa".',3)
,('Romantismo tardio','Musical Romanticism is predominantly a German phenomenon—so much so that one respected French reference work defines it entirely in terms of "The role of music in the aesthetics of German romanticism".',3)
,('Realismo','O realismo foi um movimento artístico e literário surgido nas últimas décadas do século XIX na Europa, mais especificamente na França, em reação ao romantismo. Motivados pelas teorias científicas e filosóficas da época, os escritores realistas desejavam retratar o homem e a sociedade em sua totalidade.',4)
,('Epopeia','A epopeia pertence ao gênero épico. Embora tenha fundamentos históricos, não representa os acontecimentos com fidelidade; geralmente reveste os acontecimentos relatados com conceitos morais e atos exemplares que funcionam como modelos de comportamento, além de atribuir um caráter quase divino ao herói. ',4)
,('Rock psicodélico','Rock psicadélico (pt) ou rock psicodélico (pt-BR) (psychedelic rock, em inglês) é um subgênero do rock que se desenvolveu na metade da década de 1960 e que influenciou a psicodelia. Costuma usar novas técnicas de estúdio e trazer características da música da Índia, como os pedais e o raga. ',3)
,('Pop rock','Pop rock é um estilo de rock com uma abordagem mais leve e suave que é mais semelhante à música pop mainstream. Originário da década de 1950 como uma alternativa ao rock and roll, o pop rock no início foi influenciado pela batida, arranjos e estilo do rock and roll (e às vezes do doo-wop).',3)
,('Música orquestral','Uma orquestra (do grego antigo lugar de dança  por alusão ao espaço semicircular situado em frente ao palco do teatro grego, onde dançava o coro) é um agrupamento instrumental utilizado geralmente (mas nem sempre) para a execução de música de concerto.',3)
,('Literatura brasileira','A literatura brasileira, considerando seu desenvolvimento baseada na língua portuguesa, faz parte do espectro cultural lusófono, sendo um desdobramento da literatura em língua portuguesa. Faz parte também da Literatura latino-americana, a única em língua portuguesa. Ela surgiu a partir da atividade literária incentivada pelos jesuítas após o descobrimento do Brasil durante o século XVI.',4)
,('Literatura russa','A literatura da Rússia refere-se a todos os autores russos (quer da Rússia, quer dos territórios incorporados ao longo da História) dos mais variados estilos textuais ao longo dos tempos.
A literatura russa, introduzida no ocidente na segunda metade do século XIX, conta entre os grandes mestres da literatura universal; autores como Alexander Pushkin, Fiodor Dostoievski, Liev Tolstoi, Saltykov-Shchedrin, Anton Tchekhov, Mikhail Lérmontov, Nikolai Leskov. Grandes livros foram lançados como Guerra e Paz, Anna Karenina, Contos de Petersburgo, entre outros.',4)
,('Literatura portuguesa','Denominamos Literatura de Portugal (doravante literatura portuguesa) a literatura escrita no idioma português por escritores portugueses. Fica excluída, no âmbito deste artigo, a literatura brasileira, assim como as literaturas de outros países lusófonos, e também as obras escritas em Portugal nas línguas distintas do português, como o latim e o castelhano.
Os inícios da literatura portuguesa encontram-se na poesia galego medieval, desenvolvida originalmente na Galiza e no Norte de Portugal. A Idade de ouro situa-se no Renascimento, momento em que aparecem escritores como Gil Vicente, Bernardim Ribeiro, Sá de Miranda e sobretudo o grande poeta épico Luís de Camões, autor de Os Lusíadas.',4)
,('Literatura latina','Literatura latina ou romana é o nome que se dá ao corpo de obras literárias escritas em latim, e que permanecem até hoje como um duradouro legado da cultura da Roma Antiga. Os romanos produziram diversas obras de poesia, comédia, tragédia, sátira, história e retórica, baseando-se intensamente na tradição de outras culturas, particularmente na tradição literária grega, mais amadurecida. Mesmo muito tempo depois que o Império Romano do Ocidente já havia caído, a língua e a literatura latinas continuaram a desempenhar um papel central nas civilizações europeia e ocidental. ',4)
,('Romance filosófico','No romance filosófico, o autor trata questões fundamentalmente filosóficas no contexto de um romance.[1] O romance filosófico distingue-se de um ensaio, de uma dissertação ou de um tratado filosófico, uma vez que as problemáticas e reflexões filosóficas abordadas aparecem no contexto de uma história ficcionada, mais ou menos realista. Deste modo, o romance filosófico é particularmente adequado para ilustrar a dimensão humana/antropológica da problemática filosófica, uma vez que esta fica embebida na vida das personagens do romance.',4)
,('Romance político','Political fiction employs narrative to comment on political events, systems and theories. Works of political fiction, such as political novels, often "directly criticize an existing society or present an alternative, even fantastic, reality".[1] The political novel overlaps with the social novel, proletarian novel, and social science fiction. ',4)
,('Romance psicológico','Psychological fiction (also psychological realism) is a literary genre that emphasizes interior characterization,
as well as the motives, circumstances, and internal action which is derivative from and creates external action; not content to state what happens,
it rather reveals and studies the motivation behind the action. Character and characterization are prominent, often delving deeper into characters\'
mentalities than other genres. Psychological novels are known as stories of the "inner person." Some stories employ stream of consciousness,
interior monologues, and flashbacks to illustrate characters\' mentalities. While these textual techniques are prevalent in literary modernism,
there is no deliberate effort to fragment the prose or compel the reader to interpret the text. ',4);

INSERT INTO `websiteartes`.`artista` (`nome`, `descricao`)
	VALUES ('The Beatles'
	, 'The Beatles foi uma banda de rock britânica, formada em Liverpool em 1960. É o grupo musical mais bem-sucedido e aclamado da história da música popular. Enraizada do skiffle e do rock and roll da década de 1950, a banda veio mais tarde a assumir diversos gêneros que vão do folk rock ao rock psicodélico, muitas vezes incorporando elementos da música clássica e outros, em formas inovadoras e criativas. Sua crescente popularidade, que a imprensa britânica chamava de "Beatlemania", fez com que eles crescessem em sofisticação.');
	
    INSERT INTO `websiteartes`.`artista_has_genero` (`artista_id`, `genero_id`)
		VALUES(5, 6);
	INSERT INTO `websiteartes`.`artista_has_genero` (`artista_id`, `genero_id`)
		VALUES(5, 10);
	INSERT INTO `websiteartes`.`artista_has_genero` (`artista_id`, `genero_id`)
		VALUES(5, 11);

INSERT INTO `websiteartes`.`artista` (`nome`, `descricao`)
	VALUES ('The Doors'
	, 'The Doors foi uma banda de rock psicodélico norte-americana formada em 1965 em Los Angeles, na Califórnia. O grupo era composto por Jim Morrison (voz), Ray Manzarek (teclados), Robby Krieger (guitarra) e John Densmore (bateria). A banda recebeu esse nome por sugestão de Morrison do título do livro de Aldous Huxley, The Doors of Perception.');

	INSERT INTO `websiteartes`.`artista_has_genero` (`artista_id`, `genero_id`)
		VALUES(6, 6);
	INSERT INTO `websiteartes`.`artista_has_genero` (`artista_id`, `genero_id`)
		VALUES(6, 10);
    
INSERT INTO `websiteartes`.`artista` (`nome`, `descricao`)
	VALUES ('Anton Bruckner'
	,'Anton Bruckner (Ansfelden, 4 de setembro de 1824 — Viena, 11 de outubro de 1896) foi um compositor austríaco conhecido primeiramente pelas suas sinfonias, missas e motetos. Anton Bruckner classifica-se como uma especie de Richard Wagner instrumental, de maneira que, Bruckner seria para a musica instrumental, o que Wagner foi para musica vocal.');

	INSERT INTO `websiteartes`.`artista_has_genero` (`artista_id`, `genero_id`)
		VALUES (7, 7);
	INSERT INTO `websiteartes`.`artista_has_genero` (`artista_id`, `genero_id`)
		VALUES (7, 12);
    
INSERT INTO `websiteartes`.`artista` (`nome`,`descricao`)
	VALUES ('Gustav Mahler'
	, 'Gustav Mahler (Kalischt, Boêmia - Império Austro-Húngaro - atualmente República Checa, 7 de julho de 1860 — Viena, 18 de maio de 1911) foi um regente e compositor checo-austríaco de origem judaica. Atualmente, Mahler é visto como um dos maiores compositores do período romântico, responsável por estabelecer uma ponte entre a música do século XIX com a do período moderno e por suas grandes sinfonias e ciclo de canções sinfônicas, como, por exemplo, Das Lied von der Erde (A Canção da Terra).');

	INSERT INTO `websiteartes`.`artista_has_genero` (`artista_id`, `genero_id`)
		VALUES (8, 7);
	INSERT INTO `websiteartes`.`artista_has_genero` (`artista_id`, `genero_id`)
		VALUES (8, 12);

INSERT INTO `websiteartes`.`artista` (`nome`, `descricao`)
	VALUES ('Machado de Assis'
	, 'Joaquim Maria Machado de Assis (Rio de Janeiro, 21 de junho de 1839 — Rio de Janeiro, 29 de setembro de 1908) foi um escritor brasileiro, considerado por muitos críticos, estudiosos, escritores e leitores um dos maiores senão o maior nome da literatura do Brasil.');

	INSERT INTO `websiteartes`.`artista_has_genero` (`artista_id`, `genero_id`)
		VALUES (9, 8);
	INSERT INTO `websiteartes`.`artista_has_genero` (`artista_id`, `genero_id`)
		VALUES (9, 13);

INSERT INTO `websiteartes`.`artista` (`nome`, `descricao`)
	VALUES ('Fiódor Dostoiévski'
	, 'Fiódor Mikhailovitch Dostoiévski (Moscou/Moscovo, 30 de outubro de 1821 - São Petersburgo, 28 de janeiro de 1881) foi um escritor, filósofo e jornalista do Império Russo. É considerado um dos maiores romancistas e pensadores da história, bem como um dos maiores "psicólogos" que já existiram (na acepção mais ampla do termo, como investigadores da psiquê).');

	INSERT INTO `websiteartes`.`artista_has_genero` (`artista_id`, `genero_id`)
		VALUES (10, 8);
	INSERT INTO `websiteartes`.`artista_has_genero` (`artista_id`, `genero_id`)
		VALUES (10, 14);

INSERT INTO `websiteartes`.`artista` (`nome`, `descricao`)
	VALUES ('Luis de Camões'
	, 'Luís Vaz de Camões (Lisboa, c., 1524 — Lisboa, 10 de junho de 1579 ou 1580)[nota 1] foi um poeta nacional de Portugal, considerado uma das maiores figuras da literatura lusófona e um dos grandes poetas da tradição ocidental. ');

	INSERT INTO `websiteartes`.`artista_has_genero` (`artista_id`, `genero_id`)
		VALUES (11, 9);
	INSERT INTO `websiteartes`.`artista_has_genero` (`artista_id`, `genero_id`)
		VALUES (11, 15);

INSERT INTO `websiteartes`.`artista` (`nome`, `descricao`)
	VALUES ('Virgílio'
	, 'Públio Virgílio Maro[1] ou Marão (em latim: Publius Vergilius Maro; Andes, 15 de outubro de 70 a.C. — Brundísio, 21 de setembro de 19 a.C.) foi um poeta romano clássico, autor de três grandes obras da literatura latina, as Éclogas (ou Bucólicas), as Geórgicas, e a Eneida. Uma série de poemas menores, contidos na Appendix vergiliana, são por vezes atribuídos a ele.');

	INSERT INTO `websiteartes`.`artista_has_genero` (`artista_id`, `genero_id`)
		VALUES (12, 9);
	INSERT INTO `websiteartes`.`artista_has_genero` (`artista_id`, `genero_id`)
		VALUES (12, 16);
        
INSERT INTO `websiteartes`.`artista` (`nome`, `descricao`)
	VALUES ('Liev Tolstói'
	, 'Liev Nikoláievich Tolstói, mais conhecido em português como Leon, Leo ou Liev Tolstói (Governorado de Tula, 9 de setembro de 1828 — Astapovo, 20 de novembro de 1910), foi um escritor russo, amplamente reconhecido como um dos maiores de todos os tempos. ');
        
	
INSERT INTO `websiteartes`.`obra` (`nome`, `descricao`, `dtLancamento`)
VALUES ('Os Lusíadas', 'Os Lusíadas é uma obra de poesia épica do escritor português Luís Vaz de Camões, considerada a "epopeia portuguesa por excelência". Provavelmente concluída em 1556, foi publicada pela primeira vez em 1572 no período literário do classicismo, três anos após o regresso do autor do Oriente.
A obra é composta de dez cantos, 1.102 estrofes e 8.816 versos que são oitavas decassílabas, sujeitas ao esquema rímico fixo AB AB AB CC – oitava rima camoniana. A ação central é a descoberta do caminho marítimo para a Índia por Vasco da Gama, à volta da qual se vão descrevendo outros episódios da história de Portugal, glorificando o povo português. ',
'1572-01-01');

INSERT INTO `websiteartes`.`obra` (`nome`, `descricao`, `dtLancamento`)
VALUES ('Os Irmaos Karamazov', 'Os Irmãos Karamazov é um romance de Fiódor Dostoiévski, escrito em 1879, uma das mais importantes obras das
 literaturas russa e mundial, ou, conforme afirmou Freud: "a maior obra da história". Freud considera esse romance, juntamente com Édipo Rei e 
 Hamlet, três importantes livros a respeito do embate pai e filho, e retratam o complexo de Édipo. ',
'1880-01-01');

INSERT INTO `websiteartes`.`obra` (`nome`, `descricao`, `dtLancamento`)
VALUES ('Os Demônios','Besy é um livro escrito por Fiodor Dostoiévski em 1872. A Obra foi motivada por um episódio verídico: o assassinato do estudante I. I Ivanov pelo grupo niilista liderado por Sergey Nechayev em 1869. Ao recriar ficcionalmente esse evento, o escritor cria uma das suas maiores obras, à altura de Crime e Castigo. Besy é um estudo profundo do pensamento político, social, filosófico e religioso de seu tempo. ',
'1871-01-01');

INSERT INTO `websiteartes`.`obra` (`nome`, `descricao`, `dtLancamento`)
VALUES ('Crime e Castigo','O romance se baseia numa visão sobre religião e existencialismo com um foco predominante no tema de atingir salvação por sofrimento, sem deixar de comentar algumas questões do socialismo e niilismo.
Os personagens e as descrições de seus caracteres e personalidades, bem como outras obras maiores de Fiódor Dostoiévski, inspiraram pensamentos filosóficos, sociológicos e psicológicos da segunda metade do século XIX e também no século XX. Foram influenciados Nietzsche, Sartre, Freud, Orwell, Huxley, dentre outros.',
'1866-01-01');

INSERT INTO `websiteartes`.`obra` (`nome`, `descricao`, `dtLancamento`)
VALUES ('Eneida','A Eneida (Aeneis em latim) é um poema épico latino escrito por Virgílio no século I a.C. Conta a saga de Eneias, um troiano que é salvo dos gregos em Troia, viaja errante pelo Mediterrâneo até chegar à península Itálica. Seu destino era ser o ancestral de todos os romanos.','0100-01-01');

INSERT INTO `websiteartes`.`obra` (`nome`, `descricao`, `dtLancamento`)
VALUES ('Bucólicas','Tomando como seu modelo genérico a Bucólica grega ("sobre o cuidado com o gado", assim chamada pelos temas rústicos da poesia) de Teócrito, Virgílio criou uma versão romana parcialmente por oferecer uma interpretação dramática e mítica da mudança revolucionária em Roma no período turbulento entre aproximadamente 44 e 38 a.C.. Virgílio introduziu um clamor político amplamente ausente dos poemas de Teócritos chamados idílios ("pequenas cenas" ou "vinhetas"), apesar da turbulência erótica incomodar os panoramas "idílicos" de Teócrito. ','0100-01-01');

INSERT INTO `websiteartes`.`obra` (`nome`, `descricao`, `dtLancamento`)
VALUES ('Revolver','Revolver é o sétimo álbum do grupo de rock inglês The Beatles lançado em 5 de agosto de 1966, inicialmente no Reino Unido e em 8 de agosto nos EUA. Atingiu o primeiro lugar nas paradas de sucesso americana e inglesa. Este álbum está na lista dos 200 álbuns definitivos no Rock and Roll Hall of Fame.',
'1966-08-08');

INSERT INTO `websiteartes`.`obra` (`nome`, `descricao`, `dtLancamento`)
VALUES ('Sgt. Pepper\'s Lonely Hearts Club Band','Sgt. Pepper\'s Lonely Hearts Club Band é o oitavo álbum de estúdio da banda britânica de rock The Beatles. Lançado a 26 de maio de 1967 no Reino Unido e a 2 de junho nos Estados Unidos, tornou-se imediatamente um enorme sucesso comercial e crítico, permanecendo durante 27 semanas no topo das tabelas de álbuns do Reino Unido e 15 semanas na primeira posição nos Estados Unidos. Na altura em que foi lançado, o álbum foi aclamado pela vasta maioria dos críticos pela sua inovação na produção musical, escrita e design gráfico, e por criar uma ponte que divide a musica popular e a arte legitima, bem como dar uma representação musical da geração do seu tempo e a contra-cultura contemporânea. A revista Time o considerou "uma evolução histórica no progresso da música" e a New Statesman elogiou a sua elevação da música pop ao nível de arte',
'1967-05-26');

INSERT INTO `websiteartes`.`obra` (`nome`, `descricao`, `dtLancamento`)
VALUES ('The Beatles (White Album)','The Beatles é originalmente o décimo álbum gravado em estúdio dos Beatles, lançado como disco duplo em 22 de novembro de 1968. Este álbum está na lista dos 200 álbuns definitivos no Rock and Roll Hall of Fame.',
'1968-11-22');

INSERT INTO `websiteartes`.`artista_has_obra` (`artista_id`, `obra_id`)
VALUES (5, 11);

INSERT INTO `websiteartes`.`artista_has_obra` (`artista_id`, `obra_id`)
VALUES (5, 12);

INSERT INTO `websiteartes`.`artista_has_obra` (`artista_id`, `obra_id`)
VALUES (5, 13);

INSERT INTO `websiteartes`.`artista_has_obra` (`artista_id`, `obra_id`)
VALUES (10, 6);

INSERT INTO `websiteartes`.`artista_has_obra` (`artista_id`, `obra_id`)
VALUES (10, 7);

INSERT INTO `websiteartes`.`artista_has_obra` (`artista_id`, `obra_id`)
VALUES (10, 8);

INSERT INTO `websiteartes`.`artista_has_obra` (`artista_id`, `obra_id`)
VALUES (11, 5);

INSERT INTO `websiteartes`.`artista_has_obra` (`artista_id`, `obra_id`)
VALUES (12, 9);

INSERT INTO `websiteartes`.`artista_has_obra` (`artista_id`, `obra_id`)
VALUES (12, 10);

INSERT INTO `websiteartes`.`obra_has_genero` (`obra_id`, `genero_id`)
VALUES (5, 9), (5, 15);

INSERT INTO `websiteartes`.`obra_has_genero` (`obra_id`, `genero_id`)
VALUES (6, 8), (6, 14), (6, 17);

INSERT INTO `websiteartes`.`obra_has_genero` (`obra_id`, `genero_id`)
VALUES (7, 8), (7, 14), (7, 18), (7, 19);

INSERT INTO `websiteartes`.`obra_has_genero` (`obra_id`, `genero_id`)
VALUES (8, 8), (8, 14);

INSERT INTO `websiteartes`.`obra_has_genero` (`obra_id`, `genero_id`)
VALUES (9, 9), (9, 16);

INSERT INTO `websiteartes`.`obra_has_genero` (`obra_id`, `genero_id`)
VALUES (10, 16);

INSERT INTO `websiteartes`.`obra_has_genero` (`obra_id`, `genero_id`)
VALUES (11, 10), (11, 11), (12, 10), (12, 11), (13, 10), (13, 11);

-- INSERT INTO usuario (nome, senha, adm, email, data_criacaoConta) VALUES ('admin','d033e22ae348aeb5660fc2140aec35850c4da997',1,'lucas.schwambach52@gmail.com','2019-09-01');
-- senha sha1: admin