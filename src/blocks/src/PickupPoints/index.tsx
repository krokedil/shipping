// @ts-ignore - Cant avoid this issue, but its loaded in by Webpack
import { registerCheckoutBlock, extensionCartUpdate } from '@woocommerce/blocks-checkout';
// @ts-ignore - Cant avoid this issue, but its loaded in by Webpack
import { SelectControl } from '@wordpress/components';
// @ts-ignore - Cant avoid this issue, but its loaded in by Webpack
import { registerBlockType } from '@wordpress/blocks';
// @ts-ignore - Cant avoid this issue, but its loaded in by Webpack
import ReactDOM from 'react-dom';
import React from 'react';
const metadata = require('./block.json');

const callback = ( value: any ) => {
	return value;
};

/*registerCheckoutFilters( 'my-extension-namespace', {
	itemName: callback,
} );*/

const Edit = () : JSX.Element => {
  return <></>;
}

const Block = (props: any) : JSX.Element => {
  const { cart } = props;
  console.log("cart", cart);
  const [pickupPoints, setPickupPoints] = React.useState(null);
  const [selectedPickupPoint, setSelectedPickupPoint] = React.useState(null);
  const [selectedRate, setSelectedRate] = React.useState(null);

  // If the cart did not exist, return null.
  if (!cart) {
    return null;
  }

  const { shippingRates } = cart;

  // If shippingRates is null, return null.
  if (!shippingRates) {
    return null
  }

  const getSelectedRate = () => {
    // Loop each shippingRate and find the selected one. The shipping rates is a array of packages that contains several rates each. So loop each package and their rates.
    shippingRates.forEach((shippingPackage: any) => {
      shippingPackage.shipping_rates.forEach((rate: any) => {
        if (rate.selected) {
          setSelectedRate(rate);
        }
      });
    });
  }

  const getPickupPoints = () => {
    if (selectedRate && selectedRate.meta_data) {
      const tmpPickupPoints = selectedRate.meta_data.find((meta: { key: string }) => meta.key === 'krokedil_pickup_points');
      const tmpSelectedPickupPoint = selectedRate.meta_data.find((meta: { key: string }) => meta.key === 'krokedil_selected_pickup_point');
      if (tmpPickupPoints) {
        // Json decode the value and set it to the pickupPoints variable.
        setPickupPoints( JSON.parse(tmpPickupPoints.value) );
      }

      if (tmpSelectedPickupPoint) {
        // Json decode the value and set it to the selectedPickupPoint variable.
        setSelectedPickupPoint( JSON.parse(tmpSelectedPickupPoint.value) );
      }
    }
  }

  const getElement = () => {
    const options = pickupPoints.map((pickupPoint: any) => {
      return {
        value: pickupPoint.id,
        label: pickupPoint.name,
      };
    });

    return (
      <SelectControl
        key={selectedRate.rate_id}
        className="krokedil_shipping_pickup_point__select"
        data-rate-id={selectedRate.rate_id}
        name="krokedil_shipping_pickup_point"
        id="krokedil_shipping_pickup_point"
        onChange={(value: any) => {
          const selectedPickupPoint = pickupPoints.find((pickupPoint: any) => pickupPoint.id === value);
          setSelectedPickupPoint(selectedPickupPoint);
        }}
        value={selectedPickupPoint ? selectedPickupPoint.id : ''}
        options={options}
        variant="minimal"
      />
    );
  };

  React.useEffect(() => {
    getSelectedRate();
  }, [shippingRates]);

  React.useEffect(() => {
    getPickupPoints();
  }, [selectedRate]);

  React.useEffect(() => {
    // Trigger the checkout block to refresh when the selected pickup point changes.
    if (selectedPickupPoint) {
      extensionCartUpdate( {
      namespace: "krokedil-pickup-point",
      data: {
        id: selectedPickupPoint.id,
        rate_id: selectedRate.rate_id,
      },
    });
    }
  }, [selectedPickupPoint]);

  if(!pickupPoints) {
    return null;
  }

  // If we have pickup points, render them.
  return <>
    {ReactDOM.createPortal(getElement(), document.querySelector(`input[value="${selectedRate.rate_id}"]`)?.parentElement)}
  </>;
}

registerBlockType( metadata, {
  icon: 'cart',
  category: 'woocommerce',
  edit: () => <Edit />,
  save: () => <Edit />,
});

registerCheckoutBlock({metadata, component: Block});
