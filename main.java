pubilc nem{
    icasMsCollateralDetailTb = new IcasMsCollateralDetail();
      icasMsCollateralDetailTb = landAndBuildingDAO.get(collatDetailForm.getCollateraldetailId());
      
      icasMsCollateralDetailTb.setCollateraldetailId(collatDetailForm.getCollateraldetailId());
      CmnMsRefData cmnMsRefData = new CmnMsRefData();
      cmnMsRefData.setRefdataId(Long.valueOf(collatDetailForm.getBuildingType()));
      icasMsCollateralDetailTb.setBuildingTypeId(cmnMsRefData);

      cmnMsRefData = new CmnMsRefData();
      if (collatDetailForm.getStructId() != null && !collatDetailForm.getStructId().equals("")) {
          cmnMsRefData.setRefdataId(Long.valueOf(collatDetailForm.getStructId()));
          icasMsCollateralDetailTb.setStructureId(cmnMsRefData);
      }
      if (collatDetailForm.getBuildingAreaStr() != null && !collatDetailForm.getBuildingAreaStr().equals(""))
        icasMsCollateralDetailTb
                .setBuildingArea(new BigDecimal(collatDetailForm.getBuildingAreaStr().replace(",", "")));
      icasMsCollateralDetailTb.setFloorAmount(collatDetailForm.getFloorAmount());
      icasMsCollateralDetailTb.setYearOfBuilding(collatDetailForm.getYearOfBuilding());
      landAndBuildingDAO.update(icasMsCollateralDetailTb);
}