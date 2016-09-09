-- phpMyAdmin SQL Dump
-- version 4.1.7
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Set 08, 2016 alle 11:19
-- Versione del server: 5.6.31-log
-- PHP Version: 5.3.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `lollosfilm`
--

-- --------------------------------------------------------

USE amm15_melisLorenzo;
--
-- Struttura della tabella `clienti`
--

CREATE TABLE IF NOT EXISTS `clienti` (
  `username` varchar(128) DEFAULT NULL,
  `password` varchar(128) DEFAULT NULL,
  `nome` varchar(128) DEFAULT NULL,
  `cognome` varchar(128) DEFAULT NULL,
  `email` varchar(128) DEFAULT NULL,
  `numCivico` int(11) DEFAULT NULL,
  `citta` varchar(128) DEFAULT NULL,
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `cap` varchar(5) DEFAULT NULL,
  `via` varchar(128) DEFAULT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dump dei dati per la tabella `clienti`
--

INSERT INTO `clienti` (`username`, `password`, `nome`, `cognome`, `email`, `numCivico`, `citta`, `id`, `cap`, `via`) VALUES
('cliente', 'password', 'Lorenzo', 'Melis', 'lorenzo.melis9@gmail.com', 3, 'Cagliari', 3, '09126', 'aquilona');
-- --------------------------------------------------------

--
-- Struttura della tabella `oggetti`
--

CREATE TABLE IF NOT EXISTS `oggetti` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(128) DEFAULT NULL,
  `prezzo` int(11) DEFAULT NULL,
  `descrizione` varchar(250) DEFAULT NULL,                                         -- `descrizione` text DEFAULT NULL,
  `immagine` varchar(250) DEFAULT NULL,
  `quantita` int(11) DEFAULT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dump dei dati per la tabella `oggetti`
--


INSERT INTO `oggetti` (`id`, `nome`, `prezzo`, `descrizione`, `immagine`, `quantita`) VALUES
(5, '2001 Odissea nello spazio', 13,'', '2001_piccola.jpg', 2),
(6, 'Star Wars', 14,'', 'star_piccola.jpg', 3),
(7, 'The Departed', 15, '','departed.jpg', 0),
(8, 'Il padrino', 16,'','padrino_piccola.jpg', 5),
(9, 'Il signore degli anelli', 13,'', 'lotr_piccola.jpg', 0),
(10, 'Fight Club', 12, '' ,'fightclub.jpg', 0);

/* INSERT INTO `oggetti` (`id`, `nome`, `prezzo`, `descrizione`, `immagine`, `quantita`) VALUES
(5, '2001 Odissea nello spazio', 13, 
`Ognuno è libero di speculare a suo gusto sul significato del film. Io ho tentato di rappresentare un'esperienza visiva, che aggiri la comprensione per penetrare con il suo contenuto emotivo direttamente nell'inconscio" (S. Kubrick).
Sottraendo il film a interpretazioni immediate - aprendolo quindi a infinite interpretazioni - Kubrick ci lascia soli di fronte al monolito, un significante privo di significato (1). Ci fa sperimentare la sete della comprensione, assieme all'impossibilità di oltrepassare i limiti della comprensione. Durante la visione siamo in assenza di gravità, presi dalla vertigine, rapiti dal fascino di immagini, suoni e musiche di un film quasi privo di dialoghi. 
"Le scene più forti, quelle di cui ci si ricorda, non sono mai scene in cui delle persone si parlano, ma quasi sempre scene di musica e immagini": in nessun altro film Kubrick è stato tanto fedele a questo suo assunto quanto in "2001: Odissea nello spazio".
Il titolo del film di Kubrick assume l'archetipo primo della narrativa occidentale. Il viaggio per eccellenza, alla scoperta dell'universo; la tentazione dell'immortalità (Calipso); infine il ritorno, la scelta dell'umano. Così è in Omero; per Dante, invece, Ulisse varca le colonne d'Ercole, diretto oltre l'infinito; pecca di superbia sfidando i limiti posti all'uomo da Dio. E' la colpa di Adamo, il peccato originale, connaturato all'uomo dacché l'uomo è autocosciente.
Il destino di Ulisse, dell'uomo, è intravedere l'infinito, proiettarsi in esso, per riconoscere poi che l'infinito appartiene a una dimensione altra, divina. "Direi che il concetto di Dio è l'essenza di 2001", si spinse a dire Kubrick, alludendo non a un dio tradizionale, antropomorfo, ma alla possibilità che, tra miliardi di pianeti in miliardi di galassie, una civiltà aliena potesse aver raggiunto un grado di evoluzione tale da apparire, ai nostri occhi, prossima alla divinità. 
"Non si può desiderare l'eternità perché essa non fa parte del nostro destino. Un destino imperfetto, effimero e deludente, ma l'unico che dobbiamo amare, a cui dobbiamo sempre tornare, e la storia di Ulisse è la storia di questo ritorno" (E. Carrère) (2).
Come nelle opere di M.C. Escher o di J.L. Borges, Kubrick cerca l'infinito nel finito. Più si indaga, più il senso ultimo, quello fondante, definitivo, sfugge. Il senso è dato dal segno, dal linguaggio: e il linguaggio, il logos, è opera dell'uomo, non di un dio. Al contrario di quanto postula il Vangelo di Giovanni ("In principio era il logos, e il logos era presso Dio, e il logos era Dio"), nessun senso può essere formulato che non provenga da chi lo formula: che non sia, perciò, soggettivo. 
"Esaltati all'idea di potere ‘comprendere' il mondo attraverso la scienza e di spiegarne le leggi, non ci rassegniamo all'idea che il linguaggio e il significato non esistano al di fuori di noi stessi e non siano altro che una pittura con cui coloriamo il mondo" (3).  
L'Odissea di Kubrick dialoga con Borges e con Escher in allegorie che hanno assimilato da tempo il tramonto delle illusioni razionaliste e la crisi del positivismo ottocentesco; non ne sono più annichilite. In "2001: Odissea nello spazio" si respira piuttosto una positività figlia degli anni '60, anni di conquiste tecnologiche quanto di fermenti sociali. 
La consapevolezza che l'uomo può decretare la propria distruzione (l'olocausto nucleare, oggetto del precedente film di Kubrick, "Dottor Stranamore") convive con l'entusiasmo che accompagna la vigilia dello sbarco sulla luna.
Kubrick mette in scena il fascino esaltante della ricerca, la suggestione della meraviglia e del meraviglioso, che la creazione artistica è in grado di restituire, diversamente dalla speculazione filosofica. Non ci rassegniamo all'intangibilità del senso: e pur destinati a breve vicenda, aspiriamo all'infinito. (Una delle possibili chiavi di lettura del finale di "2001" è questa: al di là dell'esistenza individuale, nella ripetitività delle generazioni l'uomo si approssima all'infinito, trascendendo la propria finitezza).
Nel suo essere congiuntamente, inestricabilmente "pessimista" e "ottimista", "2001" denuncia i limiti di una dicotomia che è estranea alle civiltà orientali, alle quali appartiene una concezione ciclica del tempo (e il cerchio è figura chiave del film di Kubrick). Viceversa in occidente abbiamo sempre avuto una concezione lineare del tempo, tendente a un fine, che dev'essere perciò necessariamente positivo o negativo. Kubrick, al contrario, detestava nel racconto cinematografico classico l'"illusorio e 'disonesto' orientarsi verso una fine da compiersi`, 
'2001_piccola.jpg', 2),
(6, 'Star Wars', 14, 
`Creare nuovi mondi. Plasmarli ogni qual volta di dettagli e piccole, spesso gradite, altrove meno, sorprese insospettabili, fino a creare delle vere e proprie mitologie e, nel mondo reale, a fondare religioni basate sulla prettamente fantasiosa e mera materia cinefila. 
George Lucas è riuscito con l'esalogia di Guerre Stellari a trasportare il Cinema di fantascienza oltre i confini stessi del genere, arrivando a toccare picchi di pubblico probabilmente secondi a nessuno, e in ogni angolo del globo. 
"Luke, io sono tuo padre", "La forza sia con te" e altre frasi storiche sono divenute quasi uno status quo, che possono uscire dalla bocca di un bambino di cinque anni o di un canuto ottantenne. L'importanza che Star Wars ha avuto per la massa, unendo platee trasversali, è ancor oggi incredibile, e a tratti inspiegabile, e non perde ogni giorno che passa un minimo del proprio smalto. 
La saga sopravvive, pur criticata nella più recente trilogia, cronologicamente antecedente a quella degli anni '80. Ma il Mito permane, la Leggenda di Luke Skywalker, Han Solo, Obi Wan, Leila, Chuwbecca, Yoda e naturalmente Darth Fener (o Vader che vogliate) continua a percorrere gli anni con la stessa potenza di un tempo. 
Dal classicismo quasi western dei capitoli quattro, cinque e sei, comunque spettacolari per l'epoca, agli sfavillanti effetti speciali dei primi tre episodi, abbiamo imparato ad affezionarci alle storie di questi eroi e anti-eroi, anime dannate in universi infiniti pronte a lottare per il destino della galassia.
Certamente le nuove leve non hanno forse il fascino dei vari Harrison Ford, Alec Guinness e Mark Hamill (la cui carriera andò in seguito clamorosamente in declino), ma permane comunque l'idea globale di una storia ancor oggi in grado di stupire e emozionarci come una favola d'altri tempi, fatta di cavalieri coraggiosi e temibili chimere, di un'epica sotterranea avvolta nella luce folgorante di una lightsaber.`, 
'star_piccola.jpg', 3),
(7, 'The Departed', 15, 
`Martin Scorsese ritorna nei luoghi che meglio conosce. Fisici quanto mentali. Non più New York, ma Boston. Non più la mafia italiana, ma quella irlandese. Quello che non cambia sono i modi di pensare, la ricerca del potere e del denaro, la violenza come unico modo per imporre la propria personalità. Le parole sono sempre inutili se servono a risolvere qualcosa. Sono i fatti quelli che contano, le azioni.
"Poliziotti o criminali... quando ti trovi davanti ad una pistola carica che differenza c'è?" - domanda Costello (Jack Nicholson, a briglia sciolta, scatenato come non mai). Perché di poliziotti e criminali parla il film, cambiandone continuamente i ruoli, in un gioco di specchi e rimandi che mozza il fiato. Billy Costigan (Leonardo DiCaprio, sempre più bravo) e Colin Sullivan (Matt Damon) sono cresciuti nello stesso quartiere. 
Diventano tutte e due poliziotti. Le loro strade si incrociano anche se i due ignorano le rispettive identità. Billy verrà infiltrato dalla polizia nella banda di Costello per incastrarlo in qualcuno dei suoi molti traffici. Dice DiCaprio a proposito del suo personaggio: "Billy viene dal mondo della delinquenza e la sua è decisamente una strada in salita. 
Credo che decida di entrare in polizia perché non ha scelta e perché vuole fare cose diverse da quelle che ha fatto per la sua famiglia. Per ironia della sorte, viene scelto per una missione da infiltrato nella quale deve far finta di essere ciò che ha scelto di non diventare assolutamente. Diciamo che in fondo, Billy sta semplicemente tentando di redimersi e di non diventare un semplice prodotto dell'ambiente nel quale è nato e cresciuto".
L'ambiente. Quello delle famiglie mafiose, della malavita, di un mondo puramente maschile con determinate regole e codici. L'ambiente, uno dei temi più importanti del cinema scorsesiano, in questo film è visto in una nuova ottica. 
Non è più quel terreno in cui i personaggi si muovono per una propria scelta e per il loro senso di appartenenza a una comunità (basti ricordare "Mean Streets" e "Goodfellas"), adesso l'ambiente è un qualcosa che va conquistato (come fa Costello) o in cui ci si ritrova contro la propria volontà e da cui si cerca di scappare (come accade a Billy). Non esiste più la comunità, è rimasto solo l'individuo. 
Costello, infatti, è prima di tutto un capo che si è costruito il proprio impero da solo, non vediamo i suoi contatti o i suoi legami con altre famiglie o altre persone. Gli unici che sono con lui sono quelli che vi lavorano. Tutta gente al di sotto. Tutti che prendono ordini dal padrone. In questo il cambiamento è netto, la famiglia è morta, rimane la malavita come impresa e commercio, la morale (che in "Mean Streets" e "Goodfellas" era innegabile) è scomparsa.
L'assenza di etica è incarnata oltre che Costello anche da Colin. Uno che ai soldi ha venduto tutto se stesso. Colin grazie alla faccia da bravo ragazzo sta facendo carriera nella polizia, ma come sappiamo è anche uno che sta sul libro paga di Costello. Ognuno ha i suoi infiltrati.
Tutti e due i personaggi principali (Billy e Colin) credono che la strada che hanno intrapreso sia una possibile via per la redenzione della propria anima. Quella di Billy, macchiata dai crimini compiuti dalla sua famiglia, fragile, consapevole di voler portare giustizia in quel mondo dal quale ha cercato in ogni modo di allontanarsi. 
Per lui la redenzione è fare arrestare Costello, riprendersi la propria identità e andarsene e Colin che aiutando la malavita crede che con i soldi guadagnati possa salire di livello sociale e così acquistare una nuova dignità.
Dice Scorsese: "In un certo senso, Colin è un personaggio ancora più tragico di Billy, perché crede che riuscirà a farla franca e mettendosi dalla parte del diavolo si è creato una sorta di strada verso la redenzione, rappresentata dall'alta società di Beacon Hill e della State House, della quale continua a fissare la cupola dorata. 
All'inizio del film vediamo Costello che insegna a Colin tutta una serie di falsi valori e a un certo punto del film, scopriamo che Colin non ha più nessun valore in cui credere".
Polizia e malavita sono i due universi nei quali si muove l'intera storia. Lealtà e tradimento i motori drammaturgici. Scorsese mette in scena uno stupendo gioco al massacro che non lascia superstiti. Ognuno deve pagare le proprie scelte, ognuno è responsabile delle proprie azioni. Martin si appoggia sul suo ormai consolidato stile espressivo. 
I momenti narrativi più veloci e ritmati sono quelli che riguardano la prima parte del film con la presentazione dei vari personaggi. Stacchi rapidi, montaggio discontinuo, una colonna sonora che scarica subito energia e adrenalina (Rolling Stones). Poi la storia inizia a svilupparsi, i movimenti di macchina diventano descrittivi, il montaggio un incastro di situazioni sempre sul punto di ribaltarsi.
I dialoghi sono pregni di quello che Scorsese definisce l'umorismo della strada. Battute di una volgarità assurda che strappano vere risate, Jack Nicholson furoreggia, Matt Damon e DiCaprio devono giocare di sponda.`, 
'departed.jpg', 0),
(8, 'Il padrino', 16, 
`Primo capitolo di una delle trilogie più famosa della storia del cinema. Il successo di questa pellicola non è dovuto solo alla storia intrecciata e avvincente ma sopratutto dalla straordinaria rosa di attori che si avvicendano. 
Al Pacino, all'epoca attore semisconosciuto, diviene una star grazie alla sua interpretazione. Marlon Brando, invece, si consacra una delle stelle più luminose nel firmamento di Hollywood, che per il ruolo di Don Vito ottienere per la seconda volta l'Oscar come migliore attore protagonista. Il film ha come tema principale "la famiglia" intesa sia come organizzazione criminale (il rispetto, la fedeltà, l'onore) sia come legame di parentela. 
I rapporti tra i cinque fratelli Corleone sono ben sviluppati ed interpretati: James Caan è l'istitivo e violento Santino (Sonny) che farebbe di tutto per proteggere la famiglia; John Cazale è l'ingenuo Alfredo (Fredo) il quale cerca di farsi largo all'interno della organizzazione con scarsi risultati; Talia Shire è l'unica figlia Costanzia (Connie); 
Robert Duvall nei panni dell'avvocato Tom Hagen (figlio adottivo di origini non italiane) ormai così integrato nella famiglia che, oltre a ricoprire il ruolo di consigliere del Padrino, viene considerato dagli altri figli di Don Vito un fratello carnale; Al Pacino è Michele (Michael), il più giovane, decorato di guerra, che si trova suo malgrado invischiato negli affari della famiglia. La regia magistrale di Coppola segue tutta la vicenda con passione. 
L'uso della macchina da presa è dosato sapientemente mantenendo un certo distacco dai personaggi senza però (s)cadere nell'oggettività documentaristica. 
La fotografia è curata in modo tale che divide la vita dei protagonisti. I caldi chiaro scuri delle occulte attività criminali si contrappongono con le colorate e luminose azioni di vita quotidiana (da notare che riusciamo a vedere la totalità del volto del padrino solo dopo che esce dal suo studio dove organizza i suoi loschi affari). 
L'amore per la famiglia non solo traspare nelle azioni dei personaggi ma è anche il sentimento che spinge Coppola a strizzare l'occhio alle sue origini italiane mettendo in scena coloriti siparietti senza cadere nel grottesco. 
Queste note di folclore italiano purtroppo sono basate sugli stereotipi degli emigrati italiani in America, si noti la spensieratezza durante l'affollatissimo banchetto nuziale di Connie quando tutti ebbri cantano e ballano una tarantella oppure quando Clemenza svela i trucchi per fare il sugo all'italiana da manuale (durante la guerra tra le famiglie). 
Questi episodi smorzano comunque la tensione e la drammaticità che permea per quasi tutto il film. Storica ormai è la colonna sonora di Nino Rota che, con sonorità del mezzogiorno italico, descrive al meglio non solo il protagonista ma tutto il film. 
La melodia del tema principale è sorniona, solenne e incisiva quel tanto che basta da rimanere, indelebilmente, nella memoria del pubblico. Uno dei film più riusciti di quel periodo che viene chiamato "New Hollywood", dove i film di Coppola e Scorsese dominavano su tutti. 
Un film questo che ormai è entrato nell'immaginario collettivo, martoriato dalla critica dell'epoca, oggi invece celebrato come un classico.`, 
'padrino_piccola.jpg', 5),
(9, 'Il signore degli anelli', 13, 
`La Compagnia dell'Anello, vista il giorno stesso dell'uscita nelle sale italiane, il 18 Gennaio 2002, mi ha fatto capire che, in un modo o nell'altro, il suo futuro avrebbe avuto a che fare con il Cinema, inteso non come semplice intrattenimento ma come una macchina straordinaria, unica fra i grandi media moderni, in cui la potenza evocativa delle storie può fondersi con la tecnologia e l'arte visiva. 
Dopo aver assistito impotenti al tracollo del grande cinema "d'avventura" degli anni '80 - '90 (quello del primo Spielberg per intenderci, o una certa saga ambientata in una Galassia lontana lontana), Jackson ha fatto il miracolo, recuperando le suggestioni dei padri nobili della Settima Arte, il piacere per il gigantismo e, perché no, una piccola dose di follia creativa, la stessa che aveva animato i kolossal biblici e gli esperimenti di Griffith, Welles o  Kubrick. 
Il Signore degli Anelli ha ri - insegnato ad almeno un paio di generazioni a sognare, in un mondo dove tutto è marketing prima che contenuto, Jackson non è voluto scendere a compromessi. C'era chi gli diceva "tre film sono troppi, facciamone uno solo", "quattro Hobbit confondono la gente, meglio ridurli a due", altri consideravano girare tre film in una volta sola un suicidio produttivo, altri ancora pensavano che gli effetti speciali non sarebbero mai stati in grado di portare sullo schermo la visione Tolkieniana, 
oggi, a quasi dieci anni dall'uscita della prima parte della Trilogia, possiamo dire che tutte queste previsioni erano sbagliate. Jackson e il suo team hanno compiuto un'impresa che rimarrà negli annali del cinema, fondendo le tecnologie più moderne con quel gusto quasi artigianale per i modellini e i mock - up. 
Minas Tirith o il Fosso di Elm (ma anche Isengard o Hobbiville) ci appaiono tremendamente realistiche proprio per questo motivo. Limitando al minimo l'uso di computer grafica invasiva, Jackson ha dato a tutta la Trilogia un feeling lontanissimo dai classici blockbuster moderni, dove la techné vince sull'epos, Il Signore degli Anelli è un'esperienza che si vive, non si guarda. Frodo siamo tutti noi, Frodo vive come scrivevano i contestatori negli anni '70, e continuerà a farlo finché la fantasia vivrà nei grandi artisti, 
ma anche nelle persone comuni che ogni giorno devono combattere con il loro personalissimo Anello del Potere. Tolkien ci ha insegnato che il male non conquista con la violenza, seduce con il fascino della sopraffazione, mentre la tecnica sfrenata può trasformare il mondo in una foresta distrutta, violentata come la piana di Fangorn. 
Jackson non solo ha avuto il merito di tradurre in immagini l'immensa visione del Signore degli Anelli ma, in un certo senso, l'ha applicata al cinema moderno, mischiandolo all'ingenuità tipica di un cineasta "non allineato, esterno alle logiche di potere di Hollywood. Questo, al di là delle considerazioni critiche sul valore intrinseco dei tre film, è il grande lascito della trilogia, e il messaggio umano di un regista che ha saputo continuare a sognare anche quando la macchina dello show  - business ha cercato di avvolgerlo con le sue spire`, 
'lotr_piccola.jpg', 0),
(10, 'Fight Club', 12, 
`Film iconoclasta per eccellenza, pellicola scomoda agli occhi di una parte consistente della critica, Fight Club conferma David Fincher come uno dei registi più talentuosi nell’attuale panorama del cinema americano. Un personaggio e il suo doppio; il cinema e il suo doppio.[T]
Fight Club trasporta lo spettatore in uno spazio privo di gravità dove ci si sente mancare la pellicola sotto i piedi. E travolti da una strana euforia ci si rende conto in un secondo momento che si sta perdendo contatto con qualcosa di più grande che ha più o meno i contorni dell’occidente.[Y] Io sono il profondo senso di vuoto di Fincher.
Sempre più convincente, l’Edward Norton di American History X, personaggio narrante del film, si consuma nell’amicizia con l’enigmatico Tyler Durden, (Brad Pitt), dando la priorità ai destabilizzanti insegnamenti di cui Tyler / Pitt lo rende partecipe, all’interno di un rapporto che potremmo definire di stretta simbiosi.[L]
Al termine di un mirabolante conflitto sostenuto ai confini dell’io, accompagnato da un continuo e cantilenante susseguirsi di indizi rivelatori, Norton / Narratore prenderà coscienza assieme allo spettatore di essere lui stesso Tyler Durden, di aver nutrito con il proprio crescente rifiuto della società e delle sue regole un invadente alter ego. 
Elegia dell’autodistruzione. Genesi di uno sdoppiamento della personalità analizzato per tappe, all’interno di un’interminabile flash back.
Punto di partenza: il disagio.[E]
Norton / Voce Narrante racconta di sé: un uomo piegato dall’insonnia, costretto a continui spostamenti attraverso il paese da un lavoro eticamente discutibile, oppresso da un’inconfessabile senso di solitudine.
Le incrinazioni presenti nello spirito di Norton / Narratore vengono descritte con implacabile senso dell’umorismo: il suo desiderio di armonia e pace interiore trova conforto soltanto nella parassitaria frequentazione di gruppi di sostegno per malattie gravi. 
Per dirla diversamente, sembra che ci si possa sentire al sicuro solo con la testa appoggiata tra le grosse tette di Bob (Meat Loaf ), un omaccione ridotto a parvenze androgine per la terapia ormonale necessaria alla cura di un tumore ai testicoli.[R]
Ma vi è un altro impostore che non si perde un incontro con i gruppi: Marla Singer, la “falsona”. Un’eroina dark che vive con apparente distacco la propria spinta autodistruttiva, splendidamente interpretata da Helena Bonham Carter. Marla con la sua apparizione mette in crisi l’equilibrio emotivo paradossalmente trovato dal protagonista solo a contatto con la malattia e la disperazione altrui. 
L’inquietudine di Norton / Narratore si placa e si trasforma attraverso l’incontro con Brad Pitt / Tyler Durden, ovvero tramite un processo di autoscissione.
Per semplificare le cose d’ora in poi, quando sarà necessario separare i due volti di Tyler Durden, questi saranno per noi Norton e Pitt ; come dire l’essenza del diurno, della veglia e dell’autocontrollo, e l’essenza del notturno e della nemesi onirica di un io frustrato dal quotidiano.
Il gioco di Fincher è sottile: ci si avvale di ogni strumento per incidere sulla pellicola le inquietudini ispirate dalla brillante penna di Chuck Palahniuk e contestualizzate dall’ intervento in sceneggiatura di Jim Uhls.`, 
'fightclub.jpg', 0); */

-- --------------------------------------------------------

--
-- Struttura della tabella `venditore`
--

CREATE TABLE IF NOT EXISTS `venditore` (
  `username` varchar(128) DEFAULT NULL,
  `password` varchar(128) DEFAULT NULL,
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dump dei dati per la tabella `venditore`
--

INSERT INTO `venditore` (`username`, `password`, `id`) VALUES
('seller', 'password', 2);


CREATE TABLE IF NOT EXISTS `carrello` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `titolo` varchar(128) DEFAULT NULL,
  `quantità` int(11) DEFAULT NULL,
   `prezzo` int(11) DEFAULT NULL,
  `id_ogg` int(11) DEFAULT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;




/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
