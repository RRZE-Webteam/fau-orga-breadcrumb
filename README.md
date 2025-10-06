# FAU Orga Breadcrumb

Plugin zur Darstellung einer organisatorischen Breadcrumb an der FAU

[![Aktuelle Version](https://img.shields.io/github/package-json/v/rrze-webteam/fau-orga-breadcrumb/master?label=Version)](https://github.com/RRZE-Webteam/fau-orga-breadcrumb)
[![Release Version](https://img.shields.io/github/v/release/rrze-webteam/fau-orga-breadcrumb?label=Release+Version)](https://github.com/rrze-webteam/fau-orga-breadcrumb/releases/)
[![GitHub License](https://img.shields.io/github/license/rrze-webteam/fau-orga-breadcrumb)](https://github.com/RRZE-Webteam/fau-orga-breadcrumb)
[![GitHub issues](https://img.shields.io/github/issues/RRZE-Webteam/fau-orga-breadcrumb)](https://github.com/RRZE-Webteam/fau-orga-breadcrumb/issues)

## Download
GitHub-Repo: https://github.com/RRZE-Webteam/fau-orga-breadcrumb

## Autor
RRZE-Webteam , http://www.rrze.fau.de

## Copryright
GNU General Public License (GPL) Version 3


## Beschreibung

Das Plugin FAU ORGA Breadcrumb erzeugt eine organisatorische Breadcrumb für die Friedrich‑Alexander‑Universität Erlangen‑Nürnberg (FAU). 
Es stellt die Breadcrumb im Frontend bereit und erzeugt das Strukturmenü für das FAU Elemental Theme. 
Es bietet eine Administrationsseite sowie Customizer‑Integration zur Zuordnung der Website zu einer organisatorischen Einheit.

Momentan werden die organisationsbezogenen Rohdaten lokal aus sprachsensitiven PHP‑Datenfiles geliefert; 
das Plugin ist jedoch so strukturiert, dass eine spätere Anbindung an das FAU.ORG‑System via API möglich ist.


## Funktionen

- Ausgabe einer organisatorischen Breadcrumb per Shortcode: 
[fauorga].

- Shortcode‑Attribut show="menu" zur Ausgabe des hierarchischen Elemental‑Menüs (Modalinhalt): 
[fauorga show="menu"].

- Administrationsseite (Einstellungen) zur Auswahl der Organisationszuordnung.
- Integration in den Theme‑Customizer (wenn Themes entsprechende Einstellungen verwenden).
- Sprachabhängige Datenladefunktion: data/{name}-{lang}.php mit Fallback auf Englisch.
- Admin CSS und optionales Frontend‑CSS werden über das Service‑Layer eingebunden.
- Spezielle Integration für das FAU Elemental Theme: Erzeugung eines hierarchischen Menüs mit Toggle‑Buttons, fakultätsspezifischen Klassen und einem Breadcrumb‑Bereich.
- Kleine JS‑Routine (im Bootstrap) entfernt doppelte Breadcrumbs, die vom Elemental‑Theme in Modalinhalten eingefügt werden können.



## Verwendung

### Shortcode
Standard‑Verwendung (nutzt konfigurierte Option oder Theme‑Inference):
[fauorga]

Elemental‑Menü / Modalinhalt:
[fauorga show="menu"]

### Verhalten
Die Ausgabe des Breadcrumbs hängt vom Site‑Typ ab (Customizer oder Legacy‑website_type). Bei bestimmten Typen (zentrale FAU‑Seite, Fakultätsportal, Kooperationen) wird bewusst keine Breadcrumb ausgegeben.
Die Einstellungsseite zeigt eine Live‑Vorschau der gewählten Organisation sowie eine Breadcrumb‑Vorschau.


## FAU Elemental Theme Integration
ElementalMenu erzeugt eine hierarchische <ul>/<li>‑Struktur, die für das Elemental‑Theme‑Modal geeignet ist. 
Die Ausgabe enthält Toggle‑Buttons für Untermenüs und fakultätsspezifische CSS‑Klassen (z. B. faculty-<slug>).
Bei Verwendung von show="menu" liefert das Plugin den kompletten Modalinhalt (Breadcrumb + Menü) zurück, so dass Themes diesen Inhalt direkt verwenden können.
Um doppelte Breadcrumbs im Elemental‑Modal zu vermeiden, entfernt das Plugin per kleinem JavaScript‑Skript vorhandene vom Theme erzeugte Breadcrumb‑Nodes im Footer.



 
