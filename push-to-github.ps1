$ErrorActionPreference = 'Stop'
Set-Location -LiteralPath $PSScriptRoot

if (-not (Get-Command git -ErrorAction SilentlyContinue)) {
    throw 'Git tidak ditemukan. Instal Git for Windows terlebih dahulu.'
}

function Invoke-Git {
    param([Parameter(Mandatory = $true)][string[]]$Arguments)

    & git @Arguments
    if ($LASTEXITCODE -ne 0) {
        throw "Perintah Git gagal: git $($Arguments -join ' ')"
    }
}

& git rev-parse --is-inside-work-tree *> $null
if ($LASTEXITCODE -ne 0) {
    Invoke-Git -Arguments @('init', '-b', 'main')
}

$originUrl = (& git remote get-url origin 2>$null | Select-Object -First 1)
if ($LASTEXITCODE -ne 0) {
    $originUrl = Read-Host 'Masukkan URL repository GitHub (HTTPS atau SSH)'
    if ([string]::IsNullOrWhiteSpace($originUrl)) {
        throw 'URL repository GitHub wajib diisi.'
    }

    Invoke-Git -Arguments @('remote', 'add', 'origin', $originUrl.Trim())
}
else {
    Write-Host "Menggunakan remote origin: $originUrl"
}

Invoke-Git -Arguments @('add', '--all')

& git diff --cached --quiet
$stagedChanges = $LASTEXITCODE
if ($stagedChanges -eq 1) {
    $commitMessage = Read-Host 'Pesan commit (kosongkan untuk "Update project")'
    if ([string]::IsNullOrWhiteSpace($commitMessage)) {
        $commitMessage = 'Update project'
    }

    Invoke-Git -Arguments @('commit', '-m', $commitMessage.Trim())
}
elseif ($stagedChanges -ne 0) {
    throw 'Gagal memeriksa perubahan yang akan di-commit.'
}
else {
    & git rev-parse --verify HEAD *> $null
    if ($LASTEXITCODE -ne 0) {
        throw 'Tidak ada file yang dapat di-commit. Pastikan project berisi file yang tidak diabaikan.'
    }
    Write-Host 'Tidak ada perubahan baru untuk di-commit.'
}

$branch = (& git branch --show-current).Trim()
if ([string]::IsNullOrWhiteSpace($branch)) {
    throw 'Tidak dapat menentukan branch Git aktif.'
}

Invoke-Git -Arguments @('push', '--set-upstream', 'origin', $branch)
Write-Host "Project berhasil di-push ke GitHub (branch: $branch)."
