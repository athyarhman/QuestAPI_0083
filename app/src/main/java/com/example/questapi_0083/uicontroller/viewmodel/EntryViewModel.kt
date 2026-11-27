package com.example.questapi_0083.uicontroller.viewmodel

import androidx.compose.runtime.getValue
import androidx.compose.runtime.mutableStateOf
import androidx.compose.runtime.setValue
import androidx.lifecycle.ViewModel
import com.example.questapi_0083.modeldata.DataSiswa
import com.example.questapi_0083.repositori.RepositoryDataSiswa
import retrofit2.Response

class EntryViewModel(
    private val repositoryDataSiswa: RepositoryDataSiswa
) : ViewModel() {

    var uiStateSiswa by mutableStateOf(UIStateSiswa())
        private set

    private fun validasiInput(uiState: DetailsSiswa = uiStateSiswa.detailsSiswa): Boolean {
        return with(uiState) {
            nama.isNotBlank() && alamat.isNotBlank() && telpon.isNotBlank()
        }
    }

    fun updateUiState(detailsSiswa: DetailsSiswa) {
        uiStateSiswa = UIStateSiswa(
            detailsSiswa = detailsSiswa,
            isEntryValid = validasiInput(detailsSiswa)
        )
    }

    suspend fun addSiswa() {
        if (!validasiInput()) return

        try {
            val respons: Response<Void> =
                repositoryDataSiswa.postDataSiswa(uiStateSiswa.detailsSiswa.toDataSiswa())

            if (respons.isSuccessful) {
                println("Sukses Tambah Data : ${respons.message()}")
            } else {
                println("Gagal tambah data : ${respons.errorBody()}")
            }
        } catch (e: Exception) {
            e.printStackTrace()
        }
    }
}

data class UIStateSiswa(
    val detailsSiswa: DetailsSiswa = DetailsSiswa(),
    val isEntryValid: Boolean = false
)

data class DetailsSiswa(
    val id: Int = 0,
    val nama: String = "",
    val alamat: String = "",
    val telpon: String = ""
)

fun DetailsSiswa.toDataSiswa(): DataSiswa = DataSiswa(
    id = id,
    nama = nama,
    alamat = alamat,
    telpon = telpon
)

fun DataSiswa.toDetailsSiswa(): DetailsSiswa = DetailsSiswa(
    id = id,
    nama = nama,
    alamat = alamat,
    telpon = telpon
)

fun DataSiswa.toUIStateSiswa(isEntryValid: Boolean = false): UIStateSiswa =
    UIStateSiswa(
        detailsSiswa = this.toDetailsSiswa(),
        isEntryValid = isEntryValid
    )
