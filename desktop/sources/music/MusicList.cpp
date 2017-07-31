#include "MusicList.h"

MusicList::MusicList()
{

}

MusicList::MusicList(const int &id, const QString &name, const int &groupId, const QString &source)
    :
      aId(id),
      aName(name),
      aGroupId(groupId),
      aSource(source)
{
}

int MusicList::id() const
{
    return aId;
}

QString MusicList::name() const
{
    return aName;
}

int MusicList::groupId() const
{
    return aGroupId;
}

QString MusicList::source() const
{
    return aSource;
}
