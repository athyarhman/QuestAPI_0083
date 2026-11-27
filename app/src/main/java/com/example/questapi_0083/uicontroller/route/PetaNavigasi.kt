package com.example.questapi_0083.uicontroller.route

import androidx.compose.runtime.Composable
import androidx.compose.ui.Modifier
import androidx.navigation.NavHostController
import androidx.navigation.compose.NavHost
import androidx.navigation.compose.composable
import androidx.navigation.compose.rememberNavController
import com.example.questapi_0083.uicontroller.view.EntrySiswaScreen
import com.example.questapi_0083.uicontroller.view.HomeScreen

@Composable
fun PetaNavigasi(
    modifier: Modifier = Modifier,
    navController: NavHostController = rememberNavController()
) {
    NavHost(
        navController = navController,
        startDestination = DestinasiHome.route,
        modifier = modifier
    ) {
        composable(route = DestinasiHome.route) {
            HomeScreen(
                navigateToItemEntry = { navController.navigate(DestinasiEntry.route) }
            )
        }
        composable(route = DestinasiEntry.route) {
            EntrySiswaScreen(
                navigateBack = { navController.navigateUp() }
            )
        }
    }
}
