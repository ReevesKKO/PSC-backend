![Back-end - Thumbnail](https://github.com/ReevesKKO/PSC-backend/assets/53497618/801e6c59-1edc-4e8f-8070-b5cbc7344dd0)
Check out [Clients-mobile-application-PSC](https://github.com/ReevesKKO/Clients-mobile-application-PSC) and [Employees-mobile-application-PSC](https://github.com/ReevesKKO/Employees-mobile-application-PSC).

## How it is supposed to work:
```mermaid
graph LR
A[Database - MySQL 8.0] --> B[PSC-backend - PHP 8.1] 
B-->A
B-->C[Clients-mobile-application-PSC - Client, Android App] 
C-->B
B-->D[Employees-mobile-application-PSC - Client, Android App]
D-->B
```
