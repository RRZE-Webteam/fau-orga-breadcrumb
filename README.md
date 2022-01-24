# FAU Orga Breadcrumb

## Download

GitHub-Repo: https://github.com/RRZE-Webteam/fau-orga-breadcrumb

## Autor

RRZE-Webteam , http://www.rrze.fau.de

## Copryright

GNU General Public License (GPL) Version 3


## Beschreibung


Dieses Plugin erstellt eine organisatorische Breadcrumb für Einrichtungen
der Friedrich-Alexaner-Universität Erlangen-Nürnberg (FAU). 

Als Provisorum werden dabei organisatorischen Daten zunächst aus einem
in diesem Plugin definierten Array vordefiniert. Später ist geplant, die
organisatorischen Daten über eine zu schaffende Schnittstelle zum
Organisationsverwaltungssystem  FAU.ORG abzurufen.

## Verwendung

Die FAU ORG Breadcrumb kann mittels Shortcode ausgegeben werden:

```html
[fauorga]
```
Bei der Default-Nutzung wird der Eintrag in den Settings resp. aus dem Customizer verwendet.
Zu beachten ist, dass dieser auch abhängig vom gewählten Website-Type sein kann. 
Bei Wahl des Website-Types als zentrales FAU-Portal, als Fakultätsportal oder als externe Kooperation wird der Shortcode keine Ausgabe liefern.

Aufruf mit Angabe einer FAU.ORG-Nummer:

```html
[fauorga org="1514000000"]
```

Mit dem Attribut org lässt sich auch der Pfad zu anderen Organisationen darstellen. Als Eingabe dient dabei die FAU.ORG Id.

Das Plugin ist nur mit bei Nutzung der Themes
    'FAU-Einrichtungen',
    'FAU-Einrichtungen-BETA',
    'FAU-Medfak',
    'FAU-RWFak',
    'FAU-Philfak',
    'FAU-Techfak',
    'FAU-Natfak',
    'FAU-Blog',
    'FAU-Jobs'

einsatzfähig.


## Entwickler-Hinweise

### CSS-Anweisungen

Die CSS Anweisungen werden mittels SASS erzeugt. Hierzu werden im Verzeichnis
  /css/sass/
alle notwendien SASS und SCSS Dateien abgelegt. Die aktiven Dateien werden in
der SCSS-Datei fau-orga-breadcrumb.scss includiert.

Die für das Plugin zu erzeugende CSS-Datei fau-orga-breadcrumb.css wird im
Verzeichnis /css abgelegt. 
Als Quellverzeichnis zur SASS-Compilierung dient daher das Verzeichnis /css/sass,
das Ausgabeverzeichnis ist /css .

Zur Erstellung der CSS-Dateien liegt ein Gulp-Skript bereit.
 
