#pragma once

#include <QStandardPaths>

const QString baseDir = QStandardPaths::writableLocation(QStandardPaths::DownloadLocation) + "/shinda/";

const QString settingsFile = baseDir + "settings.ini";
