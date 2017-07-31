#pragma once

#include <QString> // ?
#include <QDir>
#include <QFile>
#include <QList>
#include "../Helper.cpp"

class AnimeList
{
public:
    AnimeList(const int &, const QString &, const QString &);

    int id() const;

    QString name() const;

    QString imageName() const;

private:
    int aId;

    QString aName;

    QString aImageName;
};
