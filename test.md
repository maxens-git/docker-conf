# Rapport exhaustif des opérateurs Google Dorks

Le **Google Dorking** repose sur l'utilisation d'**opérateurs avancés** dans les recherches Google afin d'accéder à des informations spécifiques, parfois sensibles.

---

# Table des matières
- [1. Recherche basique](#1-recherche-basique)
- [2. Recherche par site ou domaine](#2-recherche-par-site-ou-domaine)
- [3. Recherche par contenu de page](#3-recherche-par-contenu-de-page)
- [4. Recherche de types de fichiers](#4-recherche-de-types-de-fichiers)
- [5. Recherche de liens spécifiques](#5-recherche-de-liens-spécifiques)
- [6. Recherche de cache](#6-recherche-de-cache)
- [7. Recherche par date ou plage](#7-recherche-par-date-ou-plage)
- [8. Combinaisons d'opérateurs](#8-combinaisons-dopérateurs)
- [9. Exemples typiques de Google Dorks](#9-exemples-typiques-de-google-dorks)
- [10. Notes importantes](#10-notes-importantes)
- [11. Pour aller plus loin](#11-pour-aller-plus-loin)

---

## 1. Recherche basique

| Opérateur         | Fonction                                                                                 | Exemple                                |
|-------------------|------------------------------------------------------------------------------------------|----------------------------------------|
| `"mot exact"`     | Recherche exacte d’une expression entre guillemets.                                       | `"confidential report"`                |
| `mot1 OR mot2`    | Recherche l'un ou l'autre des deux termes.                                                 | `login OR signin`                      |
| `-mot`            | Exclut un mot spécifique des résultats.                                                   | `filetype:pdf -template`               |
| `*`               | Joker : remplace un ou plusieurs mots dans la requête.                                     | `"admin * panel"`                      |

---

## 2. Recherche par site ou domaine

| Opérateur         | Fonction                                                                                 | Exemple                                |
|-------------------|------------------------------------------------------------------------------------------|----------------------------------------|
| `site:`           | Limite la recherche à un domaine ou site précis.                                          | `site:example.com`                     |
| `inurl:`          | Recherche un mot dans l'URL.                                                             | `inurl:admin`                          |
| `allinurl:`       | Tous les mots suivants doivent apparaître dans l'URL.                                     | `allinurl:login secure`                |

---

## 3. Recherche par contenu de page

| Opérateur         | Fonction                                                                                 | Exemple                                |
|-------------------|------------------------------------------------------------------------------------------|----------------------------------------|
| `intitle:`        | Recherche un mot dans le **titre** d’une page.                                             | `intitle:"index of"`                   |
| `allintitle:`     | Tous les mots suivants doivent apparaître dans le **titre**.                              | `allintitle:admin login`               |
| `intext:`         | Recherche un mot dans le **corps du texte** de la page.                                    | `intext:"password"`                    |
| `allintext:`      | Tous les mots suivants doivent apparaître dans le **texte** de la page.                   | `allintext:confidential user`          |

---

## 4. Recherche de types de fichiers

| Opérateur         | Fonction                                                                                 | Exemple                                |
|-------------------|------------------------------------------------------------------------------------------|----------------------------------------|
| `filetype:`       | Recherche un type spécifique de fichier (pdf, docx, xls, etc.).                           | `filetype:pdf site:gov confidential`   |
| `ext:`            | Synonyme de `filetype:` (moins souvent utilisé mais reconnu).                             | `ext:sql site:example.com`             |

---

## 5. Recherche de liens spécifiques

| Opérateur         | Fonction                                                                                 | Exemple                                |
|-------------------|------------------------------------------------------------------------------------------|----------------------------------------|
| `link:`           | Recherche des pages qui contiennent un lien vers une URL spécifique.                     | `link:example.com`                     |

---

## 6. Recherche de cache

| Opérateur         | Fonction                                                                                 | Exemple                                |
|-------------------|------------------------------------------------------------------------------------------|----------------------------------------|
| `cache:`          | Affiche la version en cache d'une page indexée par Google.                                | `cache:example.com`                    |

---

## 7. Recherche par date ou plage

| Opérateur         | Fonction                                                                                 | Exemple                                |
|-------------------|------------------------------------------------------------------------------------------|----------------------------------------|
| `daterange:`      | Recherche entre deux dates spécifiques (format julien, rarement utilisé aujourd'hui).    | `daterange:2457388-2457392`            |

> **Note** : Depuis 2019, `daterange:` est de moins en moins utilisé ; il est souvent remplacé par les filtres date de l'interface Google.

---

## 8. Combinaisons d'opérateurs

Les opérateurs peuvent être combinés pour des recherches complexes :

```text
site:example.com inurl:admin intitle:login filetype:php
