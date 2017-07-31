#pragma once

#include <QString>
#include <QDir>
#include <QFile>
#include <QList>
#include "../Helper.cpp"

class MusicList
{
public:
    MusicList();

    MusicList(const int &, const QString &, const int &, const QString &);

    int id() const;

    QString name() const;

    int groupId() const;

    QString source() const;

private:
    int aId;

    QString aName;

    QString aImageName;

    int aGroupId;

    QString aSource;
};
