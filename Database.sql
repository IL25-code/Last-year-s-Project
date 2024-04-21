/* DataBase:
	Progetti:
		id (PK)
		nome
		data_creazione
		descrizione
		ultima_modifica
		budget
		stato_progetto
		team_proprietario (FK)
		
	Lavoratori:
		id(PK)
		nome
		cognome
	
	Team:
		id (PK)
		nome
		capo (FK)
	
	Incarichi:
		id (PK)
		nome
		durata
		data_inizio
		data_fine
		predecessori
		id_progetto (FK)
		
	Risorse:
		id (PK)
		tipologia
		id_incarichi (FK)
		
	Utente:
		id (PK)
		nome
		cognome
		
	Utente-Progetti:
		id_utente (PK) (FK)
		id_progetto (PK) (FK)
		livello_accesso */