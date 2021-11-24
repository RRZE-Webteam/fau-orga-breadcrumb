#FAU Orga Breadcrumb

Dieses Plugin erstellt eine organisatorische Breadcrumb für Einrichtungen
der Friedrich-Alexaner-Universität Erlangen-Nürnberg (FAU). 

Als Provisorum werden dabei organisatorischen Daten zunächst aus einem
in diesem Plugin definierten Array vordefiniert. Später ist geplant, die
organisatorischen Daten über eine zu schaffende Schnittstelle zum
Organisationsverwaltungssystem  FAU.ORG abzurufen.


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
 
