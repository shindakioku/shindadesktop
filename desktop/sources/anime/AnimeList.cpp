#include "AnimeList.h"

AnimeList::AnimeList(const int &id, const QString &name, const QString &imageName)
    :
      aId(id),
      aName(name),
      aImageName(imageName)
{
}

int AnimeList::id() const
{
    return aId;
}

QString AnimeList::name() const
{
    return aName;
}

QString AnimeList::imageName() const
{
    return aImageName;
}
