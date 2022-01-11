# tidio-recruitment - php developer

## Instalacja
`make build`
Komenda wykonuje pełną instalacje aplikacji. Począwszy od budowy obrazów dockerowych przez załadowanie przykładowych danych do bazy aż po instacje paczek composerowych. Po instalacji aplikacja powinna uruchomić się pod adresem `http://localhost:4200`. Raport wyświetlony jest w formie JSON. 

W razie problemów należy kolejno wykonać polecenia ukryte pod odpowiednią komendą w Makefile:
```bash
docker-compose build
docker-compose up -d
docker exec -i payroll_db mysql -uroot -proot payroll < .docker/mysql/schema.sql
docker exec -i payroll_php composer install
```

## Interfejs endpointu:

Sortowanie, dostępne dla każdego pola ze zwrotki. Wystarczy przekazać je jako index do sortowania np:
```
localhost:4200?sort[konkretne_pole_ze_zwrotki]=asc

localhost:4200?sort[department]=asc
localhost:4200?sort[department]=desc
```

Filtrowanie dostępne dla pół `firstName`, `lastName`, `department`.
```
localhost:4200?filter[lastName]=Nowak
```

## Przykładowe zwrotki
### 200 Success - W przypadku poprawnie obsłużonego żądania
`localhost:4200?sort[fullRemuneration]=desc`
```json
[
    {
        "firstName": "Adam",
        "lastName": "Kowalski",
        "department": "HR",
        "basisOfRemuneration": "$1,000.00",
        "additionalRemuneration": "$1,000.00",
        "bonusType": "permanent",
        "fullRemuneration": "$2,000.00"
    },
    {
        "firstName": "Adam",
        "lastName": "Nowak",
        "department": "Customer Service",
        "basisOfRemuneration": "$1,100.00",
        "additionalRemuneration": "$110.00",
        "bonusType": "percentage",
        "fullRemuneration": "$1,210.00"
    }
]
```

### 400 Bad Request - W przypadku nieprawidłowego parametru lub nieobsługiwanych filtrów
`localhost:4200?sort[badparam]=desc`
```json
{
    "error": "Field badparam is not supported for sorting",
    "code": 1000
}
```

## Testy
Aplikacja jest częściowo pokryta testami jednostkowymi. Można je uruchomić przy pomocy polecenia `make test`

