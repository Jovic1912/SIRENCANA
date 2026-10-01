<?php

namespace App\Libraries;

use App\Models\KelasDosenModel;
use App\Models\KelasModel;
use App\Models\RpsModel;

class Access
{
    public static function role(): ?string
    {
        return session()->get('role');
    }

    public static function dosenId(): ?int
    {
        $id = session()->get('dosen_id');
        return $id !== null ? (int) $id : null;
    }

    public static function is(string ...$roles): bool
    {
        return in_array(self::role(), $roles, true);
    }

    public static function userName(): string
    {
        return (string) session()->get('nama');
    }

    public static function actorLabel(): string
    {
        return self::userName() . ' (' . strtoupper((string) self::role()) . ')';
    }

    public static function canViewRps(array $rps): bool
    {
        if (self::is('admin', 'kaprodi')) return true;
        if (self::is('gkm', 'gpm')) return $rps['status'] !== 'draft';
        if (self::is('dosen')) return self::dosenId() !== null && (int) $rps['pengembang_id'] === self::dosenId();
        return false;
    }

    public static function canEditRps(array $rps): bool
    {
        if (self::is('admin')) return true;
        return self::is('dosen') && self::dosenId() !== null && (int) $rps['pengembang_id'] === self::dosenId();
    }

    public static function canSignAsDosen(array $rps): bool
    {
        return self::is('dosen', 'kaprodi') && self::dosenId() !== null
            && (int) $rps['pengembang_id'] === self::dosenId();
    }

    public static function canSignAsKaprodi(array $rps): bool
    {
        if (! self::is('kaprodi')) return false;
        if (empty($rps['koor_prodi_id']) || self::dosenId() === null) return true;
        return (int) $rps['koor_prodi_id'] === self::dosenId();
    }

    public static function visibleRps(): array
    {
        $model = new RpsModel();
        if (self::is('dosen')) {
            return self::dosenId() === null ? [] : $model->where('pengembang_id', self::dosenId())->orderBy('id', 'DESC')->findAll();
        }
        if (self::is('gkm', 'gpm')) {
            return $model->where('status !=', 'draft')->orderBy('id', 'DESC')->findAll();
        }
        return $model->orderBy('id', 'DESC')->findAll();
    }

    public static function isPengampu(int $kelasId): bool
    {
        $did = self::dosenId();
        if ($did === null) return false;
        return (bool) (new KelasDosenModel())->where(['kelas_id' => $kelasId, 'dosen_id' => $did])->first();
    }

    public static function canViewKelas(int $kelasId): bool
    {
        if (self::is('admin', 'kaprodi', 'gkm', 'gpm')) return true;
        return self::is('dosen') && self::isPengampu($kelasId);
    }

    public static function canWriteKelasData(int $kelasId): bool
    {
        if (self::is('admin')) return true;
        return self::is('dosen', 'kaprodi') && self::isPengampu($kelasId);
    }

    public static function canManageKelas(int $kelasId): bool
    {
        if (self::is('admin', 'kaprodi')) return true;
        return self::is('dosen') && self::isPengampu($kelasId);
    }

    public static function visibleKelas(): array
    {
        $model = new KelasModel();
        if (self::is('dosen')) {
            $did = self::dosenId();
            if ($did === null) return [];
            $ids = array_column((new KelasDosenModel())->where('dosen_id', $did)->findAll(), 'kelas_id');
            return $ids ? $model->whereIn('id', $ids)->orderBy('id', 'DESC')->findAll() : [];
        }
        return $model->orderBy('id', 'DESC')->findAll();
    }
}
