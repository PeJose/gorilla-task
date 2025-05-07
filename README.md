# CLI Processor – Recruitment Task

A PHP 8.4 CLI application for processing service messages into `Review` and `Report` entities, exporting them to separate JSON files.

---

## Requirements

- PHP ≥ 8.4  
- Composer

---

## Local Run

```
composer install
php bin/console app:process-messages path/to/source.json
```

or 

```
composer install
composer local:process
```

**Output:**  
- `var/output/reviews.json`  
- `var/output/failures.json`  
- `var/output/unprocessed.json`

---

## Docker Run

```
docker build -t cli-app .
docker run --rm \
  -v "$(pwd)/var/output:/app/var/output" \
  -v "$(pwd)/source.json:/app/source.json" \
  cli-app app:process-messages source.json
```

or 

```
composer docker:build
composer docker:process
```

---

## Structure

- `bin/console` - entry file
- `Command/` – CLI commands  
- `Entity/` – data objects  
- `Enum/` – enumeration objects  
- `Factory/` – object construction logic  
- `Service/` – processing & output  
- `Repository/` – input loading  

---

## Tools Used

- Symfony Console  
- Symfony Filesystem
- Composer  
- PHPUnit  
- PHPStan

---

## Tests

```
composer test
```
