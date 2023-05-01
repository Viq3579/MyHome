<?php

function service_icon($service_type) {

    switch($service_type) {

        case "Cellular":

            echo "fa-signal";
            break;

        case "Internet":

            echo "fa-wifi";
            break;

        case "Cable":

            echo "fa-tv";
            break;

        case "Water Supply":

            echo "fa-water";
            break;

        case "Sewage":

            echo "fa-faucet";
            break;

        case "Gas":

            echo "fa-oil-well";
            break;

        case "Electricity":

            echo "fa-bolt";
            break;

        case "Home Cleaning":

            echo "fa-broom";
            break;

        case "Lawncare":

            echo "fa-tree";
            break;

        case "Babysitting":

            echo "fa-baby-carriage";
            break;

        case "Elderly Care":

            echo "fa-hand-holding-heart";
            break;

        case "Transport":

            echo "fa-train-subway";
            break;

        case "Mortgage":

            echo "fa-house-chimney";
            break;

        case "Home Insurance":

            echo "fa-house";
            break;

        case "Life Insurance":

            echo "fa-user-shield";
            break;

        case "Health Insurance":

            echo "fa-house-medical";
            break;

        case "Car Insurance":

            echo "fa-car";
            break;

        case "Device Insurance":

            echo "fa-mobile";
            break;

        case "Security":

            echo "fa-house-lock";
            break;

        case "Contact Dishonor":

            echo "fa-circle-exclamation";
            break;

        default:

            echo "fa-square";
            break;

    }

}

?>