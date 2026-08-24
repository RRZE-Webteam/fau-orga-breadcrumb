#!/usr/bin/env node

'use strict';

var fs = require('fs');
var path = require('path');
var sass = require('sass');
var esbuild = require('esbuild');

function ensureDir(dirPath) {
    if (!fs.existsSync(dirPath)) {
        fs.mkdirSync(dirPath, { recursive: true });
    }
}

function parseArgs(argv) {
    var mode = 'dev';
    var i;

    for (i = 2; i < argv.length; i++) {
        if (argv[i] === 'dev' || argv[i] === 'prod') {
            mode = argv[i];
        }
    }

    return { mode: mode };
}

function removeFile(filePath) {
    if (fs.existsSync(filePath)) {
        fs.unlinkSync(filePath);
    }
}

function compileSass(sourceFile, outFile, isProd) {
    var result = sass.compile(sourceFile, {
        style: isProd ? 'compressed' : 'expanded',
        sourceMap: isProd ? false : true,
        sourceMapIncludeSources: true
    });

    fs.writeFileSync(outFile, result.css, 'utf8');

    if (isProd) {
        removeFile(outFile + '.map');
        return;
    }

    if (result.sourceMap) {
        fs.writeFileSync(outFile + '.map', JSON.stringify(result.sourceMap), 'utf8');
    }
}

function compileJs(entryFile, outFile, isProd) {
    esbuild.buildSync({
        entryPoints: [entryFile],
        bundle: true,
        minify: isProd,
        sourcemap: isProd ? false : true,
        outfile: outFile,
        target: ['es2018']
    });

    if (isProd) {
        removeFile(outFile + '.map');
    }
}

function writeEmptyFile(outFile) {
    fs.writeFileSync(outFile, '', 'utf8');
    removeFile(outFile + '.map');
}

function phpArray(values) {
    var quoted = [];
    var i;

    for (i = 0; i < values.length; i++) {
        quoted.push("'" + values[i].replace(/\\/g, '\\\\').replace(/'/g, "\\'") + "'");
    }

    return 'array(' + quoted.join(', ') + ')';
}

function writeAssetPhp(outFile, dependencies, version) {
    var content = "<?php return array('dependencies' => " +
        phpArray(dependencies) +
        ", 'version' => '" +
        version.replace(/\\/g, '\\\\').replace(/'/g, "\\'") +
        "');\n";

    fs.writeFileSync(outFile, content, 'utf8');
}

function removeStaleFiles() {
    var staleFiles = [
        path.join('build', 'frontend.css'),
        path.join('build', 'frontend-rtl.css'),
        path.join('build', 'frontend.css.map'),
        path.join('build', 'frontend-rtl.css.map'),
        path.join('build', 'frontend.js'),
        path.join('build', 'frontend.js.map'),
        path.join('build', 'frontend.asset.php'),
        path.join('build', 'admin.css'),
        path.join('build', 'admin.css.map'),
        path.join('build', 'admin-rtl.css'),
        path.join('build', 'admin-rtl.css.map'),
        path.join('build', 'fau-orga-breadcrumb-rtl.css'),
        path.join('build', 'fau-orga-breadcrumb-rtl.css.map')
    ];
    var i;

    for (i = 0; i < staleFiles.length; i++) {
        removeFile(staleFiles[i]);
    }
}

function readPackageVersion() {
    var pkg = JSON.parse(fs.readFileSync('package.json', 'utf8'));

    if (typeof pkg.version !== 'string' || pkg.version.trim() === '') {
        return null;
    }

    return pkg.version.trim();
}

function buildCss(mode) {
    var isProd = mode === 'prod';

    compileSass(
        path.join('src', 'admin', 'admin.scss'),
        path.join('build', 'fau-orga-breadcrumb-admin.css'),
        isProd
    );
    compileSass(
        path.join('src', 'frontend', 'frontend.scss'),
        path.join('build', 'fau-orga-breadcrumb.css'),
        isProd
    );

    return true;
}

function buildJs(mode, version) {
    var isProd = mode === 'prod';

    writeEmptyFile(path.join('build', 'admin.js'));
    writeAssetPhp(path.join('build', 'admin.asset.php'), [], version);

    writeEmptyFile(path.join('build', 'fau-orga-breadcrumb.js'));
    writeAssetPhp(path.join('build', 'fau-orga-breadcrumb.asset.php'), [], version);

    compileJs(
        path.join('src', 'customizer', 'index.js'),
        path.join('build', 'customizer.js'),
        isProd
    );
    writeAssetPhp(path.join('build', 'customizer.asset.php'), ['jquery', 'customize-controls'], version);

    compileJs(
        path.join('src', 'modal-cleanup', 'index.js'),
        path.join('build', 'modal-cleanup.js'),
        isProd
    );
    writeAssetPhp(path.join('build', 'modal-cleanup.asset.php'), [], version);

    return true;
}

function runOnce(mode) {
    var version = readPackageVersion();

    if (version === null) {
        throw new Error('package.json has no valid version');
    }

    ensureDir('build');
    buildCss(mode);
    buildJs(mode, version);
    removeStaleFiles();

    return true;
}

function main() {
    var args = parseArgs(process.argv);
    runOnce(args.mode);
}

main();
